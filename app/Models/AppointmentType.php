<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;

class AppointmentType extends Model
{
    protected $fillable = [
        'dietitian_id',
        'name',
        'duration_minutes',
        'color',
        'description',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'duration_minutes' => 'integer',
        'sort_order' => 'integer'
    ];

    // Relationships
    public function dietitian()
    {
        return $this->belongsTo(Dietitian::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForDietitian($query, $dietitianId)
    {
        return $query->where('dietitian_id', $dietitianId);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    // Accessors
    public function getFormattedDurationAttribute()
    {
        $hours = floor($this->duration_minutes / 60);
        $minutes = $this->duration_minutes % 60;
        
        if ($hours > 0 && $minutes > 0) {
            return "{$hours}h {$minutes}m";
        } elseif ($hours > 0) {
            return "{$hours}h";
        } else {
            return "{$minutes}m";
        }
    }

    // Helper methods
    public static function getDefaultTypes()
    {
        return [
            ['name' => 'Initial Consultation', 'duration_minutes' => 60, 'color' => '#3B82F6'],
            ['name' => 'Follow-up', 'duration_minutes' => 30, 'color' => '#10B981'],
            ['name' => 'Group Session', 'duration_minutes' => 90, 'color' => '#F59E0B'],
            ['name' => 'Quick Check-in', 'duration_minutes' => 15, 'color' => '#8B5CF6'],
        ];
    }

    public function canBeDeleted()
    {
        return !$this->appointments()->exists();
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