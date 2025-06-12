<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;


// Public routes (no authentication required)
Route::prefix('v1')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
});

// Protected routes (authentication required)
Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/logout-all', [AuthController::class, 'logoutAll']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/refresh-token', [AuthController::class, 'refresh']);
    
    // Patient routes (role-based access)
    Route::middleware('role:patient')->group(function () {
        // Patient-specific endpoints will go here

        // Profile Management
        Route::get('/profile', [App\Http\Controllers\Api\V1\PatientProfileController::class, 'profile']);
        Route::put('/profile', [App\Http\Controllers\Api\V1\PatientProfileController::class, 'updateProfile']);
        Route::post('/change-password', [App\Http\Controllers\Api\V1\PatientProfileController::class, 'changePassword']);
        Route::get('/bmi', [App\Http\Controllers\Api\V1\PatientProfileController::class, 'getBMIData']);

        // Patient progress management
        Route::get('/progress', [App\Http\Controllers\Api\V1\PatientProgressController::class, 'index']);
        Route::get('/progress/latest', [App\Http\Controllers\Api\V1\PatientProgressController::class, 'latest']);
        Route::get('/progress/statistics', [App\Http\Controllers\Api\V1\PatientProgressController::class, 'statistics']);
        Route::post('/progress', [App\Http\Controllers\Api\V1\PatientProgressController::class, 'store']);
        Route::get('/progress/{id}', [App\Http\Controllers\Api\V1\PatientProgressController::class, 'show']);
        Route::put('/progress/{id}', [App\Http\Controllers\Api\V1\PatientProgressController::class, 'update']);
        Route::delete('/progress/{id}', [App\Http\Controllers\Api\V1\PatientProgressController::class, 'destroy']);
        Route::delete('/progress/{progressId}/images/{imageId}', [App\Http\Controllers\Api\V1\PatientProgressController::class, 'deleteImage']);
        
    });
    
    // Dietitian routes (role-based access)
    Route::middleware('role:dietitian')->group(function () {
        // Dietitian-specific endpoints will go here
    });
    
    // Admin routes (role-based access)
    Route::middleware('role:admin')->group(function () {
        // Admin-specific endpoints will go here
    });
});