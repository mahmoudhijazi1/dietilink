<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PatientProfileController extends Controller
{
    use ApiResponseTrait;

    /**
     * Get patient profile (for authenticated patient)
     */
    public function profile(Request $request)
    {
        $user = $request->user();
        
        if ($user->role !== 'patient') {
            return $this->errorResponse('Only patients can access their profile');
        }

        $patient = Patient::with('user')->where('user_id', $user->id)->first();
        
        if (!$patient) {
            return $this->errorResponse('Patient profile not found');
        }

        $profileData = $this->formatPatientData($patient);
        
        return $this->successResponse('Patient profile retrieved successfully', $profileData);
    }

    /**
     * Update patient profile (for authenticated patient)
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();
        
        if ($user->role !== 'patient') {
            return $this->errorResponse('Only patients can update their profile');
        }

        $patient = Patient::where('user_id', $user->id)->first();
        
        if (!$patient) {
            return $this->errorResponse('Patient profile not found');
        }

        $validator = $this->getProfileValidator($request, $user->id);
        
        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors());
        }

        // Update user information
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Update patient information
        $patient->update($this->getPatientUpdateData($request));

        $profileData = $this->formatPatientData($patient->fresh('user'));
        
        return $this->successResponse('Profile updated successfully', $profileData);
    }

    /**
     * Change password for authenticated patient
     */
    public function changePassword(Request $request)
    {
        $user = $request->user();
        
        if ($user->role !== 'patient') {
            return $this->errorResponse('Only patients can change their password');
        }

        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors());
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return $this->errorResponse('Current password is incorrect');
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return $this->successResponse('Password changed successfully');
    }

    /**
     * Get BMI data for authenticated patient
     */
    public function getBMIData(Request $request)
    {
        $user = $request->user();
        
        if ($user->role !== 'patient') {
            return $this->errorResponse('Only patients can access BMI data');
        }

        $patient = Patient::with(['progressEntries' => function ($query) {
            $query->latest()->limit(1);
        }])->where('user_id', $user->id)->first();
        
        if (!$patient) {
            return $this->errorResponse('Patient profile not found');
        }

        $bmiData = $this->getCurrentBMIData($patient);
        
        return $this->successResponse('BMI data retrieved successfully', [
            'bmi' => $bmiData,
            'age' => $this->calculateAge($patient->birth_date)
        ]);
    }

    /**
     * Format patient data for API response
     */
    private function formatPatientData($patient)
    {
        $bmiData = $this->getCurrentBMIData($patient);
        $age = $this->calculateAge($patient->birth_date);

        return [
            'user' => [
                'id' => $patient->user->id,
                'name' => $patient->user->name,
                'username' => $patient->user->username,
                'email' => $patient->user->email,
                'status' => $patient->user->status,
            ],
            'patient' => [
                'id' => $patient->id,
                
                // Personal information
                'phone' => $patient->phone,
                'gender' => $patient->gender,
                'birth_date' => $patient->birth_date,
                'age' => $age,
                'occupation' => $patient->occupation,
                
                // Physical measurements
                'height' => $patient->height,
                'initial_weight' => $patient->initial_weight,
                'goal_weight' => $patient->goal_weight,
                'activity_level' => $patient->activity_level,
                
                // Medical history
                'medical_conditions' => $patient->medical_conditions,
                'allergies' => $patient->allergies,
                'medications' => $patient->medications,
                'surgeries' => $patient->surgeries,
                'smoking_status' => $patient->smoking_status,
                'gi_symptoms' => $patient->gi_symptoms,
                'recent_blood_test' => $patient->recent_blood_test,
                
                // Food history
                'dietary_preferences' => $patient->dietary_preferences,
                'alcohol_intake' => $patient->alcohol_intake,
                'coffee_intake' => $patient->coffee_intake,
                'vitamin_intake' => $patient->vitamin_intake,
                'daily_routine' => $patient->daily_routine,
                'physical_activity_details' => $patient->physical_activity_details,
                'previous_diets' => $patient->previous_diets,
                'weight_history' => $patient->weight_history,
                'subscription_reason' => $patient->subscription_reason,
                
                // Notes
                'notes' => $patient->notes,
                'additional_info' => $patient->additional_info,
                
                // Timestamps
                'created_at' => $patient->created_at,
                'updated_at' => $patient->updated_at,
            ],
            'bmi' => $bmiData,
        ];
    }

    /**
     * Get validator for profile update
     */
    private function getProfileValidator(Request $request, $userId)
    {
        return Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $userId,
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
    }

    /**
     * Get patient update data from request
     */
    private function getPatientUpdateData(Request $request)
    {
        return [
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
        ];
    }

    /**
     * Calculate patient age from birth_date
     */
    private function calculateAge($birthDate)
    {
        if (!$birthDate) {
            return null;
        }

        return Carbon::parse($birthDate)->age;
    }

    /**
     * Calculate BMI
     */
    private function calculateBMI($height, $weight)
    {
        if (!$height || !$weight) {
            return null;
        }

        // Convert height from cm to meters
        $heightInMeters = $height / 100;
        return round($weight / ($heightInMeters * $heightInMeters), 1);
    }

    /**
     * Get BMI category and color based on BMI value
     */
    private function getBMICategory($bmi)
    {
        if (!$bmi) {
            return ['category' => 'Unknown', 'color' => 'text-slate-500'];
        }

        if ($bmi < 18.5) {
            return ['category' => 'Underweight', 'color' => 'text-blue-600'];
        } elseif ($bmi < 25) {
            return ['category' => 'Normal', 'color' => 'text-success'];
        } elseif ($bmi < 30) {
            return ['category' => 'Overweight', 'color' => 'text-warning'];
        } else {
            return ['category' => 'Obese', 'color' => 'text-error'];
        }
    }

    /**
     * Get BMI interpretation based on gender
     */
    private function getBMIInterpretation($bmi, $gender = null)
    {
        if (!$bmi) return null;
        
        $baseInfo = $this->getBMICategory($bmi);
        
        // Add gender-specific context
        $interpretation = $baseInfo['category'];
        
        if ($gender === 'male' && $bmi >= 25 && $bmi < 27) {
            $interpretation .= ' (may be muscle mass)';
        }
        
        return [
            'category' => $interpretation,
            'color' => $baseInfo['color'],
            'base_category' => $baseInfo['category']
        ];
    }

    /**
     * Get patient's current BMI data
     */
    private function getCurrentBMIData($patient)
    {
        if (!$patient->height) {
            return null;
        }

        // Get current weight (latest progress entry or initial weight)
        $currentWeight = $patient->initial_weight;
        
        if ($patient->progressEntries && $patient->progressEntries->count() > 0) {
            $latestEntry = $patient->progressEntries->first();
            $currentWeight = $latestEntry->weight ?? $currentWeight;
        }

        if (!$currentWeight) {
            return null;
        }

        $currentBMI = $this->calculateBMI($patient->height, $currentWeight);
        $bmiInfo = $this->getBMIInterpretation($currentBMI, $patient->gender);

        // Calculate initial BMI for comparison
        $initialBMI = null;
        $bmiChange = null;
        
        if ($patient->initial_weight) {
            $initialBMI = $this->calculateBMI($patient->height, $patient->initial_weight);
            if ($currentBMI && $initialBMI) {
                $bmiChange = round($currentBMI - $initialBMI, 1);
            }
        }

        return [
            'current' => $currentBMI,
            'initial' => $initialBMI,
            'change' => $bmiChange,
            'category' => $bmiInfo['category'] ?? 'Unknown',
            'color' => $bmiInfo['color'] ?? 'text-slate-500',
            'current_weight' => $currentWeight
        ];
    }
}