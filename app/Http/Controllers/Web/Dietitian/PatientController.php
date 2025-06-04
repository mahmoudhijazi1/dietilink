<?php

namespace App\Http\Controllers\Web\Dietitian;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $patientsQuery = Patient::with('user');

        // Apply search if provided
        if ($search) {
            $patientsQuery->whereHas('user', function ($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            })
                ->orWhere('phone', 'LIKE', "%{$search}%");
        }

        $patients = $patientsQuery->latest()->paginate(10);

        if ($request->ajax()) {
            return view('dietitian.patients.partials.patients-table', compact('patients'))->render();
        }

        return view('dietitian.patients.index', compact('patients', 'search'));
    }

    public function show($id)
    {
        $patient = Patient::with([
            'user',
            'progressEntries' => function ($query) {
                $query->latest();
            }
        ])
            ->findOrFail($id);

        return view('dietitian.patients.show', compact('patient'));
    }

    /**
     * Show invite form for new patient
     */
    public function inviteView()
    {
        return view('dietitian.patients.invite');
    }

    /**
     * Submit invite request via web
     */
    public function inviteSubmit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();

        $token = Str::random(40);

        $patient = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'patient',
            'tenant_id' => $user->tenant_id,
            'invitation_token' => $token,
            'invitation_sent_at' => now(),
            'status' => 'invited',
            'password' => '',
        ]);

        // Create patient record
        Patient::create([
            'user_id' => $patient->id,
            // Default values if needed
        ]);

        return redirect()->route('dietitian.patients.index')
            ->with('success', 'Patient invitation sent successfully!');
    }

    /**
     * Show the form for editing patient
     */
    public function edit($id)
    {
        $patient = Patient::with('user')->findOrFail($id);
        return view('dietitian.patients.edit', compact('patient'));
    }

    /**
     * Update the patient information
     */
    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $patient->user_id,
            'height' => 'nullable|numeric',
            'initial_weight' => 'nullable|numeric',
            'goal_weight' => 'nullable|numeric',
            'activity_level' => 'nullable|string',
            'medical_conditions' => 'nullable|string',
            'allergies' => 'nullable|string',
            'dietary_preferences' => 'nullable|string',
            'notes' => 'nullable|string',
            'phone' => 'nullable|string',
            'gender' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update user information
        $patient->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Update patient information
        $patient->update([
            'height' => $request->height,
            'initial_weight' => $request->initial_weight,
            'goal_weight' => $request->goal_weight,
            'activity_level' => $request->activity_level,
            'medical_conditions' => $request->medical_conditions,
            'allergies' => $request->allergies,
            'dietary_preferences' => $request->dietary_preferences,
            'notes' => $request->notes,
            'phone' => $request->phone,
            'gender' => $request->gender,
        ]);

        return redirect()->route('dietitian.patients.show', $patient->id)
            ->with('success', 'Patient information updated successfully!');
    }

    /**
     * Delete a patient
     */
    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $user = $patient->user;

        // Delete the patient record
        $patient->delete();

        // Optionally delete the user as well or just mark as inactive
        $user->update(['status' => 'deleted']);

        return redirect()->route('dietitian.patients.index')
            ->with('success', 'Patient deleted successfully!');
    }
    public function sendInviteEmail(Request $request)
    {
    }
}