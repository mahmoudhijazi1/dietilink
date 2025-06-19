<?php

// app/Models/Patient.php

namespace App\Models;

use App\Models\Traits\BelongsToTenantThroughUser;
use Auth;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    // use BelongsToTenantThroughUser;
    protected $fillable = [
        'user_id',
        'height',
        'initial_weight',
        'goal_weight',
        'activity_level',
        'medical_conditions',
        'allergies',
        'dietary_preferences',
        'notes',
        'additional_info',
        'phone',
        'gender',

        // Add these to your Patient model $fillable array:

        // Personal Info
        'occupation',
        'birth_date',

        // Medical History  
        'medications',
        'surgeries',
        'smoking_status',
        'gi_symptoms',
        'recent_blood_test',

        // Food History
        'alcohol_intake',
        'coffee_intake',
        'vitamin_intake',
        'daily_routine',
        'physical_activity_details',
        'previous_diets',
        'weight_history',
        'subscription_reason'
    ];

    protected $casts = [
        'additional_info' => 'array', // for json column
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function progressEntries()
    {
        return $this->hasMany(ProgressEntry::class);
    }
    
    public function mealPlans()
    {
        return $this->hasMany(MealPlan::class);
    }

    // NEW: Relationship to appointments
    public function appointments()
    {
        return $this->hasMany(Appointment::class)->orderBy('appointment_date')->orderBy('start_time');
    }

    // NEW: Get upcoming appointments
    public function getUpcomingAppointments($limit = null)
    {
        $query = $this->appointments()->upcoming()->with(['dietitian.user', 'appointmentType']);
        
        if ($limit) {
            $query->limit($limit);
        }
        
        return $query->get();
    }

    // NEW: Get past appointments
    public function getPastAppointments($limit = null)
    {
        $query = $this->appointments()->past()->with(['dietitian.user', 'appointmentType']);
        
        if ($limit) {
            $query->limit($limit);
        }
        
        return $query->get();
    }

    // NEW: Get next appointment
    public function getNextAppointment()
    {
        return $this->appointments()
            ->upcoming()
            ->with(['dietitian.user', 'appointmentType'])
            ->first();
    }

    // NEW: Get appointments with a specific dietitian
    public function getAppointmentsWithDietitian($dietitianId)
    {
        return $this->appointments()
            ->forDietitian($dietitianId)
            ->with(['appointmentType'])
            ->orderBy('appointment_date', 'desc')
            ->orderBy('start_time', 'desc')
            ->get();
    }

    // NEW: Check if patient has any upcoming appointments
    public function hasUpcomingAppointments()
    {
        return $this->appointments()->upcoming()->exists();
    }

    // NEW: Check if patient has appointments with specific dietitian
    public function hasAppointmentsWith($dietitianId)
    {
        return $this->appointments()->forDietitian($dietitianId)->exists();
    }

    // NEW: Get appointment count by status
    public function getAppointmentCountByStatus($status = null)
    {
        $query = $this->appointments();
        
        if ($status) {
            $query->byStatus($status);
        }
        
        return $query->count();
    }

    // NEW: Get last completed appointment
    public function getLastCompletedAppointment()
    {
        return $this->appointments()
            ->byStatus('completed')
            ->with(['dietitian.user', 'appointmentType'])
            ->orderBy('appointment_date', 'desc')
            ->orderBy('start_time', 'desc')
            ->first();
    }

    // add boot
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