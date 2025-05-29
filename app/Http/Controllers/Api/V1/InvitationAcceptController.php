<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class InvitationAcceptController extends Controller
{
    /**
     * Show the invited patient's info for prefill.
     */
    public function show($token)
    {
         $user = User::where('invitation_token', $token)->first();

    if (!$user || $user->status !== 'invited') {
        return response()->json([
            'message' => 'This invitation link is no longer valid. It may have already been used or expired.'
        ], 410); // 410 Gone is a good RESTful status for expired resources
    }

    return response()->json([
        'name'  => $user->name,
        'email' => $user->email,
    ]);
}

public function accept(Request $request, $token)
{
    $user = User::where('invitation_token', $token)->first();

    if (!$user || $user->status !== 'invited') {
        return response()->json([
            'message' => 'This invitation link is no longer valid. It may have already been used or expired.'
        ], 410); // 410 Gone
    }


        // Validate onboarding fields
        $request->validate([
            'password'        => ['required', 'confirmed', 'min:7'],
            'phone'           => ['required', 'string', 'max:20'],
            'gender'          => ['required', 'in:male,female,other'],
            'height'          => ['required', 'numeric', 'min:0'],
            'initial_weight'  => ['required', 'numeric', 'min:0'],
        ]);

        // Update user credentials and status
        $user->update([
            'password' => Hash::make($request->password),
            'invitation_token' => null,
            'invitation_accepted_at' => now(),
            'status' => 'active',
        ]);

        // Ensure patient profile exists, create if not
        if (!$user->patient) {
            $user->patient()->create([
                'phone' => $request->phone,
                'gender' => $request->gender,
                'height' => $request->height,
                'initial_weight' => $request->initial_weight,
            ]);
        } else {
            $user->patient->update([
                'phone' => $request->phone,
                'gender' => $request->gender,
                'height' => $request->height,
                'initial_weight' => $request->initial_weight,
            ]);
        }

        // Optionally: auto-login and return token here

        return response()->json(['message' => 'Registration complete. You can now log in.']);
    }
}
