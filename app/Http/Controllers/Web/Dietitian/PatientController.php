<?php

namespace App\Http\Controllers\Web\Dietitian;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use Hash;
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
                ->orWhere('phone', 'LIKE', "%{$search}%")
                ->orWhere('occupation', 'LIKE', "%{$search}%");
        }

        $patients = $patientsQuery->latest()->paginate(10);

        if ($request->ajax()) {
            return view('dietitian.patients.partials.patients-table', compact('patients'))->render();
        }

        return view('dietitian.patients.index', compact('patients', 'search'));
    }

    public function create(){
        return view('dietitian.patients.create');
    }


    public function createWithCredentials(Request $request)
{
    $request->validate([
        // Required fields
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users,username',
        'password' => 'required|string|min:8',
        
        // Optional fields with validation
        'phone' => 'nullable|string|max:20',
        'gender' => 'nullable|string|in:male,female,other',
        'date_of_birth' => 'nullable|date|before:today',
        'occupation' => 'nullable|string|max:255',
    ]);

    // Create the user account
    $user = User::create([
        'name' => $request->name,
        'username' => $request->username,
        'email' => $request->username . '@example.com', // Temporary email, can be updated later
        'password' => Hash::make($request->password),
        'role' => 'patient',
        'tenant_id' => auth()->user()->tenant_id,
        'status' => 'active',
    ]);

    // Create the patient profile with all available data
    Patient::create([
        'user_id' => $user->id,
        
        // Personal information
        'phone' => $request->phone,
        'gender' => $request->gender,
        'birth_date' => $request->date_of_birth,
        'occupation' => $request->occupation,
        
        // All other fields will be null initially and can be filled later
        // Physical measurements
        'height' => null,
        'initial_weight' => null,
        'goal_weight' => null,
        'activity_level' => null,
        
        // Medical history
        'medical_conditions' => null,
        'allergies' => null,
        'medications' => null,
        'surgeries' => null,
        'smoking_status' => null,
        'gi_symptoms' => null,
        'recent_blood_test' => null,
        
        // Food history
        'dietary_preferences' => null,
        'alcohol_intake' => null,
        'coffee_intake' => null,
        'vitamin_intake' => null,
        'daily_routine' => null,
        'physical_activity_details' => null,
        'previous_diets' => null,
        'weight_history' => null,
        'subscription_reason' => null,
        
        // Notes
        'notes' => null,
    ]);

    return redirect()->route('dietitian.patients.index')
        ->with('success', 'Patient "' . $request->name . '" created successfully with login credentials.');
}

    
public function checkUsername(Request $request)
{
    $username = $request->get('username');
    
    if (empty($username) || strlen($username) < 3) {
        return response()->json([
            'available' => null,
            'message' => ''
        ]);
    }
    
    $exists = User::where('username', $username)->exists();
    
    return response()->json([
        'available' => !$exists,
        'message' => $exists ? 'Username is already taken' : 'Username is available'
    ]);
}

    public function show($id)
    {
        $patient = Patient::with([
            'user',
            'progressEntries' => function ($query) {
                $query->latest();
            },
            'mealPlans' => function ($query) {
                $query->with(['meals.mealItems.foodItem'])->latest();
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
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|string|in:male,female,other',
            'occupation' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date|before:today',

            // Physical measurements
            'height' => 'nullable|numeric|min:50|max:300',
            'initial_weight' => 'nullable|numeric|min:20|max:500',
            'goal_weight' => 'nullable|numeric|min:20|max:500',
            'activity_level' => 'nullable|string|max:255',

            // Medical history
            'medical_conditions' => 'nullable|string',
            'medications' => 'nullable|string',
            'surgeries' => 'nullable|string',
            'smoking_status' => 'nullable|string',
            'gi_symptoms' => 'nullable|string',
            'recent_blood_test' => 'nullable|string',
            'allergies' => 'nullable|string',

            // Food history
            'dietary_preferences' => 'nullable|string',
            'alcohol_intake' => 'nullable|string',
            'coffee_intake' => 'nullable|string',
            'vitamin_intake' => 'nullable|string',
            'daily_routine' => 'nullable|string',
            'physical_activity_details' => 'nullable|string',
            'previous_diets' => 'nullable|string',
            'weight_history' => 'nullable|string',
            'subscription_reason' => 'nullable|string',

            // Notes
            'notes' => 'nullable|string',
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
            'phone' => $request->phone,
            'gender' => $request->gender,
            'occupation' => $request->occupation,
            'birth_date' => $request->birth_date,

            // Physical measurements
            'height' => $request->height,
            'initial_weight' => $request->initial_weight,
            'goal_weight' => $request->goal_weight,
            'activity_level' => $request->activity_level,

            // Medical history
            'medical_conditions' => $request->medical_conditions,
            'medications' => $request->medications,
            'surgeries' => $request->surgeries,
            'smoking_status' => $request->smoking_status,
            'gi_symptoms' => $request->gi_symptoms,
            'recent_blood_test' => $request->recent_blood_test,
            'allergies' => $request->allergies,

            // Food history
            'dietary_preferences' => $request->dietary_preferences,
            'alcohol_intake' => $request->alcohol_intake,
            'coffee_intake' => $request->coffee_intake,
            'vitamin_intake' => $request->vitamin_intake,
            'daily_routine' => $request->daily_routine,
            'physical_activity_details' => $request->physical_activity_details,
            'previous_diets' => $request->previous_diets,
            'weight_history' => $request->weight_history,
            'subscription_reason' => $request->subscription_reason,

            // Notes
            'notes' => $request->notes,
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
        $user->update(['status' => 'inactive']);

        return redirect()->route('dietitian.patients.index')
            ->with('success', 'Patient deleted successfully!');
    }

    /**
     * Calculate patient age from birth_date
     */
    private function calculateAge($birthDate)
    {
        if (!$birthDate)
            return null;

        return \Carbon\Carbon::parse($birthDate)->age;
    }

    /**
     * Calculate BMI if height and weight are available
     */
    private function calculateBMI($height, $weight)
    {
        if (!$height || !$weight)
            return null;

        // Convert height from cm to meters
        $heightInMeters = $height / 100;
        return round($weight / ($heightInMeters * $heightInMeters), 1);
    }

    public function sendInviteEmail(Request $request)
    {
        // Implementation for sending invitation emails
    }
}