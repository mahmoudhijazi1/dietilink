<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureTenantScope
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        // Only check for tenant_id if not super_admin
        if ($user && !$user->tenant_id && $user->role !== 'super_admin') {
            return response()->json(['message' => 'No tenant assigned.'], 403);
        }
        return $next($request);
    }
}

