<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\AvailabilitySlot;
use App\Models\Dietitian;
use Carbon\Carbon;

class AvailableTimeSlotsService
{
    /**
     * Get available time slots for a dietitian on a specific date
     * 
     * @param Dietitian $dietitian
     * @param string $date (Y-m-d format)
     * @param int $durationMinutes
     * @param int $slotIncrement (default 15 minutes)
     * @return array
     */
    public function getAvailableSlots(Dietitian $dietitian, string $date, int $durationMinutes, int $slotIncrement = 15): array
    {
        $carbonDate = Carbon::parse($date);
        $dayOfWeek = $carbonDate->dayOfWeek;

        // Get availability slots for this day
        $availabilitySlots = $dietitian->availabilitySlots()
            ->active()
            ->forDay($dayOfWeek)
            ->orderBy('start_time')
            ->get();

        if ($availabilitySlots->isEmpty()) {
            return [];
        }

        // Get existing appointments for this date
        $existingAppointments = $dietitian->appointments()
            ->onDate($date)
            ->where('status', '!=', 'canceled')
            ->orderBy('start_time')
            ->get(['start_time', 'end_time']);

        $availableSlots = [];

        foreach ($availabilitySlots as $availabilitySlot) {
            $slots = $this->generateSlotsForAvailabilityWindow(
                $availabilitySlot->start_time,
                $availabilitySlot->end_time,
                $durationMinutes,
                $slotIncrement,
                $existingAppointments,
                $carbonDate
            );

            $availableSlots = array_merge($availableSlots, $slots);
        }

        // Sort by time and remove duplicates
        $availableSlots = collect($availableSlots)
            ->unique('start_time')
            ->sortBy('start_time')
            ->values()
            ->toArray();

        return $availableSlots;
    }

    /**
     * Generate available slots for a single availability window
     */
    private function generateSlotsForAvailabilityWindow(
        string $windowStart, 
        string $windowEnd, 
        int $durationMinutes, 
        int $slotIncrement,
        $existingAppointments,
        Carbon $date
    ): array {
        $slots = [];
        $currentTime = Carbon::parse($windowStart);
        $endTime = Carbon::parse($windowEnd);

        // Don't allow booking in the past
        $now = now();
        if ($date->isToday()) {
            $minimumTime = $now->copy()->addMinutes(30); // 30 minutes minimum advance booking
            if ($currentTime->lt($minimumTime)) {
                $currentTime = $minimumTime->copy();
                // Round up to next slot increment
                $minutes = $currentTime->minute;
                $roundedMinutes = ceil($minutes / $slotIncrement) * $slotIncrement;
                $currentTime->minute($roundedMinutes)->second(0);
            }
        }

        while ($currentTime->copy()->addMinutes($durationMinutes)->lte($endTime)) {
            $slotStart = $currentTime->format('H:i');
            $slotEnd = $currentTime->copy()->addMinutes($durationMinutes)->format('H:i');

            // Check if this slot conflicts with existing appointments
            if (!$this->slotConflictsWithAppointments($slotStart, $slotEnd, $existingAppointments)) {
                $slots[] = [
                    'start_time' => $slotStart,
                    'end_time' => $slotEnd,
                    'formatted_time' => Carbon::parse($slotStart)->format('g:i A'),
                    'formatted_range' => Carbon::parse($slotStart)->format('g:i A') . ' - ' . Carbon::parse($slotEnd)->format('g:i A')
                ];
            }

            $currentTime->addMinutes($slotIncrement);
        }

        return $slots;
    }

    /**
     * Check if a time slot conflicts with existing appointments
     */
    private function slotConflictsWithAppointments(string $slotStart, string $slotEnd, $existingAppointments): bool
    {
        foreach ($existingAppointments as $appointment) {
            $appointmentStart = $appointment->start_time instanceof Carbon 
                ? $appointment->start_time->format('H:i')
                : Carbon::parse($appointment->start_time)->format('H:i');
            
            $appointmentEnd = $appointment->end_time instanceof Carbon 
                ? $appointment->end_time->format('H:i')
                : Carbon::parse($appointment->end_time)->format('H:i');

            // Check for overlap
            if ($this->timesOverlap($slotStart, $slotEnd, $appointmentStart, $appointmentEnd)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if two time ranges overlap
     */
    private function timesOverlap(string $start1, string $end1, string $start2, string $end2): bool
    {
        $start1 = Carbon::parse($start1);
        $end1 = Carbon::parse($end1);
        $start2 = Carbon::parse($start2);
        $end2 = Carbon::parse($end2);

        return $start1->lt($end2) && $end1->gt($start2);
    }

    /**
     * Get available slots for multiple dates (useful for calendar view)
     */
    public function getAvailableSlotsForDateRange(
        Dietitian $dietitian, 
        string $startDate, 
        string $endDate, 
        int $durationMinutes,
        int $slotIncrement = 15
    ): array {
        $result = [];
        $current = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        while ($current->lte($end)) {
            $dateStr = $current->format('Y-m-d');
            $slots = $this->getAvailableSlots($dietitian, $dateStr, $durationMinutes, $slotIncrement);
            
            if (!empty($slots)) {
                $result[$dateStr] = [
                    'date' => $dateStr,
                    'formatted_date' => $current->format('M j, Y'),
                    'day_name' => $current->format('l'),
                    'slots_count' => count($slots),
                    'slots' => $slots
                ];
            }

            $current->addDay();
        }

        return $result;
    }

    /**
     * Check if a specific time slot is available
     */
    public function isTimeSlotAvailable(
        Dietitian $dietitian, 
        string $date, 
        string $startTime, 
        int $durationMinutes,
        ?int $excludeAppointmentId = null
    ): bool {
        $carbonDate = Carbon::parse($date);
        $dayOfWeek = $carbonDate->dayOfWeek;
        $endTime = Carbon::parse($startTime)->addMinutes($durationMinutes)->format('H:i');

        // Check if it fits within availability
        $hasAvailability = $dietitian->availabilitySlots()
            ->active()
            ->forDay($dayOfWeek)
            ->where('start_time', '<=', $startTime)
            ->where('end_time', '>=', $endTime)
            ->exists();

        if (!$hasAvailability) {
            return false;
        }

        // Check for conflicts with existing appointments
        $query = $dietitian->appointments()
            ->onDate($date)
            ->where('status', '!=', 'canceled')
            ->where(function ($q) use ($startTime, $endTime) {
                $q->whereBetween('start_time', [$startTime, $endTime])
                  ->orWhereBetween('end_time', [$startTime, $endTime])
                  ->orWhere(function ($subQ) use ($startTime, $endTime) {
                      $subQ->where('start_time', '<=', $startTime)
                           ->where('end_time', '>=', $endTime);
                  });
            });

        if ($excludeAppointmentId) {
            $query->where('id', '!=', $excludeAppointmentId);
        }

        return !$query->exists();
    }

    /**
     * Get next available slot for a specific duration
     */
    public function getNextAvailableSlot(Dietitian $dietitian, int $durationMinutes, int $maxDaysAhead = 30): ?array
    {
        $currentDate = now()->startOfDay();
        $endDate = $currentDate->copy()->addDays($maxDaysAhead);

        while ($currentDate->lte($endDate)) {
            $slots = $this->getAvailableSlots(
                $dietitian, 
                $currentDate->format('Y-m-d'), 
                $durationMinutes
            );

            if (!empty($slots)) {
                return [
                    'date' => $currentDate->format('Y-m-d'),
                    'formatted_date' => $currentDate->format('M j, Y'),
                    'slot' => $slots[0] // Return first available slot
                ];
            }

            $currentDate->addDay();
        }

        return null;
    }

    /**
     * Get daily summary of available slots
     */
    public function getDailySummary(Dietitian $dietitian, string $date): array
    {
        $carbonDate = Carbon::parse($date);
        $dayOfWeek = $carbonDate->dayOfWeek;

        // Get availability slots for this day
        $availabilitySlots = $dietitian->availabilitySlots()
            ->active()
            ->forDay($dayOfWeek)
            ->get();

        if ($availabilitySlots->isEmpty()) {
            return [
                'date' => $date,
                'formatted_date' => $carbonDate->format('M j, Y'),
                'has_availability' => false,
                'total_availability_minutes' => 0,
                'appointments_count' => 0,
                'available_slots_count' => 0
            ];
        }

        // Calculate total availability minutes
        $totalAvailabilityMinutes = $availabilitySlots->sum(function ($slot) {
            return Carbon::parse($slot->start_time)->diffInMinutes(Carbon::parse($slot->end_time));
        });

        // Get appointments for this date
        $appointments = $dietitian->appointments()
            ->onDate($date)
            ->where('status', '!=', 'canceled')
            ->get();

        // Get available slots for different durations
        $availableSlots30 = $this->getAvailableSlots($dietitian, $date, 30);
        $availableSlots60 = $this->getAvailableSlots($dietitian, $date, 60);

        return [
            'date' => $date,
            'formatted_date' => $carbonDate->format('M j, Y'),
            'day_name' => $carbonDate->format('l'),
            'has_availability' => true,
            'total_availability_minutes' => $totalAvailabilityMinutes,
            'appointments_count' => $appointments->count(),
            'available_slots_30min' => count($availableSlots30),
            'available_slots_60min' => count($availableSlots60),
            'first_available_30min' => $availableSlots30[0] ?? null,
            'first_available_60min' => $availableSlots60[0] ?? null
        ];
    }
}