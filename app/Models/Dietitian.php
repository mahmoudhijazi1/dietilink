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

    // NEW: Relationship to availability slots
    public function availabilitySlots()
    {
        return $this->hasMany(AvailabilitySlot::class)->orderBy('day_of_week')->orderBy('start_time');
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