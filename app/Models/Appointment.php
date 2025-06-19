<?php

namespace App\Models;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'dietitian_id',
        'patient_id',
        'appointment_type_id',
        'appointment_date',
        'start_time',
        'end_time',
        'status',
        'notes',
        'dietitian_notes',
        'created_by_user_id',
        'canceled_at',
        'canceled_by_user_id',
        'cancellation_reason'
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'canceled_at' => 'datetime'
    ];

    // Relationships
    public function dietitian()
    {
        return $this->belongsTo(Dietitian::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function appointmentType()
    {
        return $this->belongsTo(AppointmentType::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function canceledBy()
    {
        return $this->belongsTo(User::class, 'canceled_by_user_id');
    }

    // Scopes
    public function scopeForDietitian($query, $dietitianId)
    {
        return $query->where('dietitian_id', $dietitianId);
    }

    public function scopeForPatient($query, $patientId)
    {
        return $query->where('patient_id', $patientId);
    }

    public function scopeOnDate($query, $date)
    {
        return $query->where('appointment_date', $date);
    }

    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('appointment_date', [$startDate, $endDate]);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('appointment_date', '>=', now()->toDateString())
                    ->where('status', 'scheduled')
                    ->orderBy('appointment_date')
                    ->orderBy('start_time');
    }

    public function scopePast($query)
    {
        return $query->where('appointment_date', '<', now()->toDateString())
                    ->orderBy('appointment_date', 'desc')
                    ->orderBy('start_time', 'desc');
    }

    // Accessors
    public function getFormattedDateAttribute()
    {
        return $this->appointment_date->format('M j, Y');
    }

    public function getFormattedTimeRangeAttribute()
    {
        return Carbon::parse($this->start_time)->format('g:i A') . ' - ' . 
               Carbon::parse($this->end_time)->format('g:i A');
    }

    public function getFormattedDateTimeAttribute()
    {
        return $this->formatted_date . ' at ' . $this->formatted_time_range;
    }

    public function getDurationMinutesAttribute()
    {
        $start = Carbon::parse($this->start_time);
        $end = Carbon::parse($this->end_time);
        return $start->diffInMinutes($end);
    }

    public function getIsUpcomingAttribute()
    {
        return $this->appointment_date >= now()->toDateString() && $this->status === 'scheduled';
    }

    public function getIsPastAttribute()
    {
        return $this->appointment_date < now()->toDateString();
    }

    public function getCanBeCanceledAttribute()
    {
        return in_array($this->status, ['scheduled']) && $this->is_upcoming;
    }

    public function getCanBeRescheduledAttribute()
    {
        return in_array($this->status, ['scheduled']) && $this->is_upcoming;
    }

    public function getCanBeCompletedAttribute()
    {
        return $this->status === 'scheduled' && 
               $this->appointment_date <= now()->toDateString();
    }

    // Helper methods
    public function overlapsWithExisting()
    {
        return static::where('dietitian_id', $this->dietitian_id)
            ->where('appointment_date', $this->appointment_date)
            ->where('id', '!=', $this->id ?? 0)
            ->where('status', '!=', 'canceled')
            ->where(function ($query) {
                $query->whereBetween('start_time', [$this->start_time, $this->end_time])
                    ->orWhereBetween('end_time', [$this->start_time, $this->end_time])
                    ->orWhere(function ($q) {
                        $q->where('start_time', '<=', $this->start_time)
                          ->where('end_time', '>=', $this->end_time);
                    });
            })
            ->exists();
    }

    public function fitsWithinAvailability()
    {
        $dayOfWeek = $this->appointment_date->dayOfWeek;
        
        return AvailabilitySlot::where('dietitian_id', $this->dietitian_id)
            ->where('day_of_week', $dayOfWeek)
            ->active()
            ->where('start_time', '<=', $this->start_time)
            ->where('end_time', '>=', $this->end_time)
            ->exists();
    }

    public function cancel($reason = null, $userId = null)
    {
        $this->update([
            'status' => 'canceled',
            'canceled_at' => now(),
            'canceled_by_user_id' => $userId ?: auth()->id(),
            'cancellation_reason' => $reason
        ]);
    }

    public function complete($notes = null)
    {
        $this->update([
            'status' => 'completed',
            'dietitian_notes' => $notes
        ]);
    }

    public function markNoShow($notes = null)
    {
        $this->update([
            'status' => 'no_show',
            'dietitian_notes' => $notes
        ]);
    }

    // Global scope for tenant isolation
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('', function ($query) {
            $user = Auth::user();

            if ($user && $user->tenant_id && $user->role !== 'super_admin') {
                $query->whereHas('dietitian', function ($q) use ($user) {
                    $q->whereHas('user', function ($userQuery) use ($user) {
                        $userQuery->where('tenant_id', $user->tenant_id);
                    });
                });
            }
        });
    }
}