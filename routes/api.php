<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\InvitePatientController;
use App\Http\Controllers\Api\V1\InvitationAcceptController;

// All API routes are under /api/v1
Route::prefix('v1')->group(function () {

    // --- Authentication (Public) ---
    Route::post('login', [AuthController::class, 'login']);
    // You can add register route for super admin/dietitian if needed
    Route::get('debug-token/{token}', function($token) {
    return \App\Models\User::where('invitation_token', $token)->get();
});
Route::middleware('auth:sanctum')->prefix('patient')->group(function () {
    Route::get('profile', [\App\Http\Controllers\Api\V1\PatientProfileController::class, 'show']);
    Route::put('profile', [\App\Http\Controllers\Api\V1\PatientProfileController::class, 'update']);
});


    // --- Invitation Accept (Public for patient) ---
    Route::get('invite/accept/{token}', [InvitationAcceptController::class, 'show']);
    Route::post('invite/accept/{token}', [InvitationAcceptController::class, 'accept']);

    // --- Protected routes: User must be authenticated ---
    Route::middleware('auth:sanctum')->group(function () {

        // Logout (any user)
        Route::post('logout', [AuthController::class, 'logout']);

        // Get current user (any user)
        Route::get('me', [AuthController::class, 'me']);

        // --- Tenant-protected routes (dietitian actions) ---
        Route::middleware('tenant')->group(function () {
            // Dietitian invites a patient
            Route::post('invite-patient', [InvitePatientController::class, 'invite']);
        });

        // Add other authenticated (but not necessarily tenant-scoped) endpoints here
    });

    // Add other public routes here if needed
});
