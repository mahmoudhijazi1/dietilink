<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\InvitePatientController;
use App\Http\Controllers\Api\V1\InvitationAcceptController;
use App\Http\Controllers\Api\V1\PatientProfileController;
use App\Http\Controllers\Api\V1\PatientProgressController;

// ==============================
// API ROUTES FOR /api/v1/*
// ==============================

Route::prefix('v1')->group(function () {

    // === PUBLIC ENDPOINTS ===

    // Patient accepts invitation (public - no auth)
    Route::get('invite/accept/{token}', [InvitationAcceptController::class, 'show']);
    Route::post('invite/accept/{token}', [InvitationAcceptController::class, 'accept']);

    // Authentication (login - public)
    Route::post('login', [AuthController::class, 'login']);

    // Debug endpoint (REMOVE in production)
    Route::get('debug-token/{token}', function ($token) {
        return \App\Models\User::where('invitation_token', $token)->get();
    });

    // === PATIENT ENDPOINTS (MOBILE APP) ===
    // - These routes require the user to be authenticated (usually a patient)
    // - They do NOT need 'tenant' middleware, as the patient is already scoped
    Route::middleware('auth:sanctum')->prefix('patient')->group(function () {

        // Profile management
        Route::get('profile', [PatientProfileController::class, 'show']);
        Route::put('profile', [PatientProfileController::class, 'update']);

        // Progress tracking
        Route::prefix('progress')->group(function () {
            Route::get('/', [PatientProgressController::class, 'index']);
            Route::post('/', [PatientProgressController::class, 'store']);
            Route::get('/latest', [PatientProgressController::class, 'latest']);
            // Add show/update/destroy if needed later
        });

        // Future: Add more patient-only endpoints here
    });

    // === GENERIC AUTH-PROTECTED ENDPOINTS (ALL USERS) ===
    Route::middleware('auth:sanctum')->group(function () {
        // Logout current user (patient or dietitian)
        Route::post('logout', [AuthController::class, 'logout']);

        // Get current logged-in user info
        Route::get('me', [AuthController::class, 'me']);
    });

    // === DIETITIAN/ADMIN ENDPOINTS ===
    // - These routes require BOTH authentication and tenant context
    Route::middleware(['auth:sanctum', 'tenant'])->group(function () {

        // Dietitian invites a patient
        Route::post('invite-patient', [InvitePatientController::class, 'invite']);

        // Future: Add dietitian/admin-only endpoints here (manage patients, meal plans, etc)
    });

    // === PUBLIC ENDPOINTS (if needed) ===
    // Add other routes here if needed (e.g., general info, support, etc)
});
