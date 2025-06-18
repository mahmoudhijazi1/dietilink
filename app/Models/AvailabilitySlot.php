<?php

namespace App\Models;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;

class AvailabilitySlot extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'dietitian_id',
        'day_of_week',
        'start_time',
        'end_time',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    // Relationships
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function dietitian()
    {
        return $this->belongsTo(Dietitian::class);
    }

    // Scopes
    public function scopeForDietitian($query, $dietitianId)
    {
        return $query->where('dietitian_id', $dietitianId);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForDay($query, $dayOfWeek)
    {
        return $query->where('day_of_week', $dayOfWeek);
    }

    // Accessors
    public function getDayNameAttribute()
    {
        $days = [
            0 => 'Sunday',
            1 => 'Monday', 
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday'
        ];
        
        return $days[$this->day_of_week] ?? 'Unknown';
    }

    public function getFormattedTimeRangeAttribute()
    {
        return Carbon::parse($this->start_time)->format('g:i A') . ' - ' . 
               Carbon::parse($this->end_time)->format('g:i A');
    }

    // Helper methods
    public static function getDaysOfWeek()
    {
        return [
            1 => 'Monday',
            2 => 'Tuesday', 
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
            0 => 'Sunday'
        ];
    }

    public static function getTimeOptions()
    {
        $times = [];
        for ($hour = 6; $hour <= 22; $hour++) {
            for ($minute = 0; $minute < 60; $minute += 30) {
                $time = sprintf('%02d:%02d', $hour, $minute);
                $display = Carbon::createFromFormat('H:i', $time)->format('g:i A');
                $times[$time] = $display;
            }
        }
        return $times;
    }

    // Validation helper
    public function overlapsWithExisting()
    {
        return static::where('dietitian_id', $this->dietitian_id)
            ->where('day_of_week', $this->day_of_week)
            ->where('id', '!=', $this->id ?? 0)
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
}