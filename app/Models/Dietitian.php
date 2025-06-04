<?php

// app/Models/Dietitian.php

namespace App\Models;

use App\Models\Traits\BelongsToTenantThroughUser;
use Auth;
use Illuminate\Database\Eloquent\Model;

class Dietitian extends Model
{
    // use BelongsToTenantThroughUser;

    protected $fillable = [
        'user_id', 'clinic_name', 'phone', 'bio'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
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
