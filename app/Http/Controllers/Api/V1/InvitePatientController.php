<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class InvitePatientController extends Controller
{
    public function invite(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        $user = $request->user(); // The dietitian

        // Create invitation token
        $token = Str::random(40);

        // Create new user as patient
        $patient = User::create([
            'name'              => $request->name,
            'email'             => $request->email,
            'role'              => 'patient',
            'tenant_id'         => $user->tenant_id,
            'invitation_token'  => $token,
            'invitation_sent_at'=> now(),
            'status'            => 'invited',
            'password'          => '', // Not set yet
        ]);

        // Optionally, send an email with the invite link
        // Mail::to($patient->email)->send(new PatientInvitationMail($token));

        return response()->json([
            'message' => 'Invitation sent!',
            'invite_link' => url('api/v1/invite/accept/' . $token)
        ]);
    }
}

