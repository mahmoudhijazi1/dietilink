<?php

// app/Models/Dietitian.php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;

class Dietitian extends Model
{
    protected $fillable = [
        'user_id', 'clinic_name', 'phone', 'bio'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship to availability slots
    public function availabilitySlots()
    {
        return $this->hasMany(AvailabilitySlot::class)->orderBy('day_of_week')->orderBy('start_time');
    }

    // NEW: Relationship to appointment types
    public function appointmentTypes()
    {
        return $this->hasMany(AppointmentType::class)->ordered();
    }

    // NEW: Relationship to appointments
    public function appointments()
    {
        return $this->hasMany(Appointment::class)->orderBy('appointment_date')->orderBy('start_time');
    }

    // Helper method to get grouped availability by day
    public function getWeeklyAvailability()
    {
        return $this->availabilitySlots()
            ->active()
            ->get()
            ->groupBy('day_of_week')
            ->map(function ($slots) {
                return $slots->map(function ($slot) {
                    return [
                        'id' => $slot->id,
                        'start_time' => $slot->start_time,
                        'end_time' => $slot->end_time,
                        'formatted_range' => $slot->formatted_time_range
                    ];
                });
            });
    }

    // Check if dietitian has any availability
    public function hasAvailability()
    {
        return $this->availabilitySlots()->active()->exists();
    }

    // NEW: Get upcoming appointments
    public function getUpcomingAppointments($limit = null)
    {
        $query = $this->appointments()->upcoming()->with(['patient.user', 'appointmentType']);
        
        if ($limit) {
            $query->limit($limit);
        }
        
        return $query->get();
    }

    // NEW: Get appointments for a specific date
    public function getAppointmentsForDate($date)
    {
        return $this->appointments()
            ->onDate($date)
            ->with(['patient.user', 'appointmentType'])
            ->orderBy('start_time')
            ->get();
    }

    // NEW: Get appointments for date range
    public function getAppointmentsForDateRange($startDate, $endDate)
    {
        return $this->appointments()
            ->dateRange($startDate, $endDate)
            ->with(['patient.user', 'appointmentType'])
            ->orderBy('appointment_date')
            ->orderBy('start_time')
            ->get();
    }

    // NEW: Check if dietitian has active appointment types
    public function hasAppointmentTypes()
    {
        return $this->appointmentTypes()->active()->exists();
    }

    // NEW: Get or create default appointment types
    public function getOrCreateDefaultAppointmentTypes()
    {
        if (!$this->hasAppointmentTypes()) {
            $defaultTypes = AppointmentType::getDefaultTypes();
            
            foreach ($defaultTypes as $index => $typeData) {
                $this->appointmentTypes()->create([
                    'name' => $typeData['name'],
                    'duration_minutes' => $typeData['duration_minutes'],
                    'color' => $typeData['color'],
                    'sort_order' => $index
                ]);
            }
        }
        
        return $this->appointmentTypes()->active()->ordered()->get();
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('', function ($query) {
            $user = Auth::user();

            if ($user && $user->tenant_id && $user->role !== 'super_admin') {
                $query->whereHas('user', function ($q) use ($user) {
                    $q->where('tenant_id', $user->tenant_id);
                });
            }
        });
    }
}