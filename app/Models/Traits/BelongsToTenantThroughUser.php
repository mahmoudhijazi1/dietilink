<?php
namespace App\Models\Traits;

use Illuminate\Support\Facades\Auth;

trait BelongsToTenantThroughUser
{
    public function scopeForTenant($query)
    {
        $user = Auth::user();
        if ($user && $user->tenant_id && $user->role !== 'super_admin') {
            $query->whereHas('user', function ($q) use ($user) {
                $q->where('tenant_id', $user->tenant_id);
            });
        }
        return $query;
    }
}
