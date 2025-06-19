<?php

namespace App\Http\Controllers\Web\Dietitian;

use App\Http\Controllers\Controller;
use App\Models\AvailabilitySlot;
use App\Services\AvailableTimeSlotsService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentCalendarController extends Controller
{
    protected $availableTimeSlotsService;

    public function __construct(AvailableTimeSlotsService $availableTimeSlotsService)
    {
        $this->availableTimeSlotsService = $availableTimeSlotsService;
    }

    /**
     * Show calendar view
     */
    public function index(Request $request)
    {
        $dietitian = auth()->user()->dietitian;
        
        if (!$dietitian) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Dietitian profile not found.'
                ], 404);
            }
            return redirect()->route('dietitian.dashboard')
                ->with('error', 'Dietitian profile not found.');
        }

        // Default to current week
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : now()->startOfWeek();
        $view = $request->view ?? 'week'; // week or month

        if ($view === 'month') {
            $startDate = $startDate->startOfMonth();
            $endDate = $startDate->copy()->endOfMonth();
        } else {
            $endDate = $startDate->copy()->endOfWeek();
        }

        $appointmentTypes = $dietitian->appointmentTypes()->active()->ordered()->get();

        if (request()->wantsJson()) {
            return $this->getCalendarData($dietitian, $startDate, $endDate, $view);
        }

        return view('dietitian.appointments.calendar', compact(
            'startDate', 
            'endDate', 
            'view', 
            'appointmentTypes'
        ));
    }

    /**
     * Get calendar data for AJAX requests
     */
    public function getCalendarData(Request $request)
    {
        $dietitian = auth()->user()->dietitian;
        
        if (!$dietitian) {
            return response()->json([
                'success' => false, 
                'message' => 'Dietitian profile not found.'
            ], 404);
        }

        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'view' => 'required|in:week,month'
        ]);

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $view = $request->view;

        return $this->buildCalendarResponse($dietitian, $startDate, $endDate, $view);
    }

    /**
     * Build calendar response data
     */
    private function buildCalendarResponse($dietitian, Carbon $startDate, Carbon $endDate, string $view)
    {
        // Get availability slots
        $availabilitySlots = $dietitian->availabilitySlots()
            ->active()
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get()
            ->groupBy('day_of_week');

        // Get appointments for the date range
        $appointments = $dietitian->appointments()
            ->dateRange($startDate->format('Y-m-d'), $endDate->format('Y-m-d'))
            ->with(['patient.user', 'appointmentType'])
            ->orderBy('appointment_date')
            ->orderBy('start_time')
            ->get()
            ->groupBy(function($appointment) {
                return $appointment->appointment_date->format('Y-m-d');
            });

        // Build calendar structure
        $calendarData = [];
        $currentDate = $startDate->copy();

        while ($currentDate->lte($endDate)) {
            $dateStr = $currentDate->format('Y-m-d');
            $dayOfWeek = $currentDate->dayOfWeek;
            
            // Get availability for this day
            $dayAvailability = $availabilitySlots->get($dayOfWeek, collect())->map(function($slot) {
                return [
                    'id' => $slot->id,
                    'start_time' => $slot->start_time->format('H:i'),
                    'end_time' => $slot->end_time->format('H:i'),
                    'formatted_range' => $slot->formatted_time_range
                ];
            });

            // Get appointments for this day
            $dayAppointments = $appointments->get($dateStr, collect())->map(function($appointment) {
                return [
                    'id' => $appointment->id,
                    'patient_name' => $appointment->patient->user->name,
                    'appointment_type' => $appointment->appointmentType->name,
                    'start_time' => $appointment->start_time->format('H:i'),
                    'end_time' => $appointment->end_time->format('H:i'),
                    'formatted_time_range' => $appointment->formatted_time_range,
                    'status' => $appointment->status,
                    'color' => $appointment->appointmentType->color,
                    'notes' => $appointment->notes,
                    'can_be_edited' => $appointment->can_be_rescheduled
                ];
            });

            // Get daily summary if it's week view
            $summary = null;
            if ($view === 'month') {
                $summary = $this->availableTimeSlotsService->getDailySummary($dietitian, $dateStr);
            }

            $calendarData[] = [
                'date' => $dateStr,
                'formatted_date' => $currentDate->format('M j, Y'),
                'day_name' => $currentDate->format('l'),
                'day_short' => $currentDate->format('D'),
                'day_number' => $currentDate->format('j'),
                'is_today' => $currentDate->isToday(),
                'is_past' => $currentDate->isPast(),
                'availability_slots' => $dayAvailability->toArray(),
                'appointments' => $dayAppointments->toArray(),
                'appointments_count' => $dayAppointments->count(),
                'has_availability' => $dayAvailability->isNotEmpty(),
                'summary' => $summary
            ];

            $currentDate->addDay();
        }

        return response()->json([
            'success' => true,
            'calendar_data' => $calendarData,
            'view' => $view,
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'navigation' => [
                'prev_period' => $this->getPreviousPeriod($startDate, $view),
                'next_period' => $this->getNextPeriod($startDate, $view),
                'current_period_label' => $this->getPeriodLabel($startDate, $view)
            ]
        ]);
    }

    /**
     * Get previous period dates
     */
    private function getPreviousPeriod(Carbon $date, string $view): array
    {
        if ($view === 'month') {
            $prev = $date->copy()->subMonth()->startOfMonth();
            return [
                'start_date' => $prev->format('Y-m-d'),
                'end_date' => $prev->copy()->endOfMonth()->format('Y-m-d')
            ];
        } else {
            $prev = $date->copy()->subWeek()->startOfWeek();
            return [
                'start_date' => $prev->format('Y-m-d'),
                'end_date' => $prev->copy()->endOfWeek()->format('Y-m-d')
            ];
        }
    }

    /**
     * Get next period dates
     */
    private function getNextPeriod(Carbon $date, string $view): array
    {
        if ($view === 'month') {
            $next = $date->copy()->addMonth()->startOfMonth();
            return [
                'start_date' => $next->format('Y-m-d'),
                'end_date' => $next->copy()->endOfMonth()->format('Y-m-d')
            ];
        } else {
            $next = $date->copy()->addWeek()->startOfWeek();
            return [
                'start_date' => $next->format('Y-m-d'),
                'end_date' => $next->copy()->endOfWeek()->format('Y-m-d')
            ];
        }
    }

    /**
     * Get period label for display
     */
    private function getPeriodLabel(Carbon $date, string $view): string
    {
        if ($view === 'month') {
            return $date->format('F Y');
        } else {
            $endOfWeek = $date->copy()->endOfWeek();
            return $date->format('M j') . ' - ' . $endOfWeek->format('M j, Y');
        }
    }
}