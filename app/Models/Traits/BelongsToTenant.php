<?php
namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait BelongsToTenant
{
    protected static function bootBelongsToTenant()
    {
        static::addGlobalScope('tenant', function (Builder $builder) {
            $user = Auth::user();
            if ($user && $user->tenant_id && $user->role !== 'super_admin') {
                $builder->where('tenant_id', $user->tenant_id);
            }
        });

        static::creating(function ($model) {
            $user = Auth::user();
            if ($user && $user->tenant_id && $user->role !== 'super_admin') {
                $model->tenant_id = $user->tenant_id;
            }
        });
    }
}
