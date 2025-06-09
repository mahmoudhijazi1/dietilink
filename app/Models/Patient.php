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
        'gender'
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
