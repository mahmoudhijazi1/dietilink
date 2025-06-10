<?php
// app/Models/User.php

namespace App\Models;

use App\Models\Traits\BelongsToTenant;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'tenant_id',
        'role',
        'invitation_token',
        'invitation_sent_at',
        'status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relationship: Each user belongs to a tenant (nullable for super_admin)
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    // If user is a dietitian, has one Dietitian
    public function dietitian()
    {
        return $this->hasOne(Dietitian::class);
    }

    // If user is a patient, has one Patient
    public function patient()
    {
        return $this->hasOne(Patient::class);

    }

    // In your model:
    public function scopeForTenant($query)
    {
        $user = Auth::user();
        if ($user && $user->tenant_id && $user->role !== 'super_admin') {
            $query->where('tenant_id', $user->tenant_id);
        }
        return $query;
    }

    
}
