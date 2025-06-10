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
                ->orWhere('phone', 'LIKE', "%{$search}%")
                ->orWhere('occupation', 'LIKE', "%{$search}%");
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
        if (!$birthDate) return null;
        
        return \Carbon\Carbon::parse($birthDate)->age;
    }

    /**
     * Calculate BMI if height and weight are available
     */
    private function calculateBMI($height, $weight)
    {
        if (!$height || !$weight) return null;
        
        // Convert height from cm to meters
        $heightInMeters = $height / 100;
        return round($weight / ($heightInMeters * $heightInMeters), 1);
    }

    public function sendInviteEmail(Request $request)
    {
        // Implementation for sending invitation emails
    }
}