<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PatientProfileController extends Controller
{
    // Show profile info for logged-in patient
    public function show(Request $request)
    {
        $user = $request->user();
        $patient = $user->patient;

        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $patient->phone,
            'gender' => $patient->gender,
            'height' => $patient->height,
            'initial_weight' => $patient->initial_weight,
            'activity_level' => $patient->activity_level,
            'dietary_preferences' => $patient->dietary_preferences,
            'allergies' => $patient->allergies,
            // ...add any fields you want to expose
        ]);
    }

    // Update profile info for logged-in patient
    public function update(Request $request)
    {
        $user = $request->user();
        $patient = $user->patient;

        $validated = $request->validate([
            'phone' => ['nullable', 'string', 'max:20'],
            'gender' => ['nullable', 'in:male,female,other'],
            'height' => ['nullable', 'numeric', 'min:0'],
            'initial_weight' => ['nullable', 'numeric', 'min:0'],
            'activity_level' => ['nullable', 'string', 'max:50'],
            'dietary_preferences' => ['nullable', 'string', 'max:255'],
            'allergies' => ['nullable', 'string', 'max:255'],
        ]);

        $patient->update($validated);

        return response()->json(['message' => 'Profile updated successfully.']);
    }
}
