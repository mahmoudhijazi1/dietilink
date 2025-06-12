<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Patient;
use App\Models\ProgressEntry;
use App\Models\ProgressImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PatientProgressController extends Controller
{
    use ApiResponseTrait;

    /**
     * Get patient's progress history
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        if ($user->role !== 'patient') {
            return $this->errorResponse('Only patients can access their progress');
        }

        $patient = Patient::where('user_id', $user->id)->first();
        
        if (!$patient) {
            return $this->errorResponse('Patient profile not found');
        }

        $perPage = $request->get('per_page', 20);
        $perPage = min($perPage, 50); // Max 50 per page

        $progressEntries = ProgressEntry::with('progressImages')
            ->where('patient_id', $patient->id)
            ->latest('measurement_date')
            ->latest('created_at')
            ->paginate($perPage);

        return $this->successResponse('Progress entries retrieved successfully', [
            'progress_entries' => $progressEntries->items(),
            'pagination' => [
                'current_page' => $progressEntries->currentPage(),
                'total_pages' => $progressEntries->lastPage(),
                'total_entries' => $progressEntries->total(),
                'per_page' => $progressEntries->perPage(),
                'has_next_page' => $progressEntries->hasMorePages(),
                'has_previous_page' => $progressEntries->currentPage() > 1,
            ]
        ]);
    }

    /**
     * Get latest progress entry
     */
    public function latest(Request $request)
    {
        $user = $request->user();
        
        if ($user->role !== 'patient') {
            return $this->errorResponse('Only patients can access their progress');
        }

        $patient = Patient::where('user_id', $user->id)->first();
        
        if (!$patient) {
            return $this->errorResponse('Patient profile not found');
        }

        $latestEntry = ProgressEntry::with('progressImages')
            ->where('patient_id', $patient->id)
            ->latest('measurement_date')
            ->latest('created_at')
            ->first();

        if (!$latestEntry) {
            return $this->successResponse('No progress entries found', ['progress_entry' => null]);
        }

        return $this->successResponse('Latest progress entry retrieved successfully', [
            'progress_entry' => $this->formatProgressEntry($latestEntry)
        ]);
    }

    /**
     * Get specific progress entry
     */
    public function show(Request $request, $id)
    {
        $user = $request->user();
        
        if ($user->role !== 'patient') {
            return $this->errorResponse('Only patients can access their progress');
        }

        $patient = Patient::where('user_id', $user->id)->first();
        
        if (!$patient) {
            return $this->errorResponse('Patient profile not found');
        }

        $progressEntry = ProgressEntry::with('progressImages')
            ->where('patient_id', $patient->id)
            ->where('id', $id)
            ->first();

        if (!$progressEntry) {
            return $this->notFoundResponse('Progress entry not found');
        }

        return $this->successResponse('Progress entry retrieved successfully', [
            'progress_entry' => $this->formatProgressEntry($progressEntry)
        ]);
    }

    /**
     * Create new progress entry
     */
    public function store(Request $request)
    {
        $user = $request->user();
        
        if ($user->role !== 'patient') {
            return $this->errorResponse('Only patients can create progress entries');
        }

        $patient = Patient::where('user_id', $user->id)->first();
        
        if (!$patient) {
            return $this->errorResponse('Patient profile not found');
        }

        $validator = $this->getProgressValidator($request);
        
        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors());
        }

        // Create the progress entry
        $progressEntry = ProgressEntry::create([
            'patient_id' => $patient->id,
            'weight' => $request->weight,
            'measurement_date' => $request->measurement_date,
            'notes' => $request->notes,
            
            // Individual measurement fields
            'chest' => $request->chest,
            'left_arm' => $request->left_arm,
            'right_arm' => $request->right_arm,
            'waist' => $request->waist,
            'hips' => $request->hips,
            'left_thigh' => $request->left_thigh,
            'right_thigh' => $request->right_thigh,
            
            // Body composition
            'fat_mass' => $request->fat_mass,
            'muscle_mass' => $request->muscle_mass,
        ]);

        // Handle progress images upload
        if ($request->hasFile('progress_images')) {
            $this->uploadProgressImages($progressEntry, $request->file('progress_images'));
        }

        $progressEntry->load('progressImages');

        return $this->successResponse('Progress entry created successfully', [
            'progress_entry' => $this->formatProgressEntry($progressEntry)
        ]);
    }

    /**
     * Update progress entry
     */
    public function update(Request $request, $id)
    {
        $user = $request->user();
        
        if ($user->role !== 'patient') {
            return $this->errorResponse('Only patients can update their progress');
        }

        $patient = Patient::where('user_id', $user->id)->first();
        
        if (!$patient) {
            return $this->errorResponse('Patient profile not found');
        }

        $progressEntry = ProgressEntry::where('patient_id', $patient->id)
            ->where('id', $id)
            ->first();

        if (!$progressEntry) {
            return $this->notFoundResponse('Progress entry not found');
        }

        $validator = $this->getProgressValidator($request, true);
        
        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors());
        }

        // Update the progress entry
        $progressEntry->update([
            'weight' => $request->weight,
            'measurement_date' => $request->measurement_date,
            'notes' => $request->notes,
            
            // Individual measurement fields
            'chest' => $request->chest,
            'left_arm' => $request->left_arm,
            'right_arm' => $request->right_arm,
            'waist' => $request->waist,
            'hips' => $request->hips,
            'left_thigh' => $request->left_thigh,
            'right_thigh' => $request->right_thigh,
            
            // Body composition
            'fat_mass' => $request->fat_mass,
            'muscle_mass' => $request->muscle_mass,
        ]);

        // Handle image deletions
        if ($request->has('delete_images')) {
            $this->deleteProgressImages($request->delete_images);
        }

        // Handle new image uploads
        if ($request->hasFile('progress_images')) {
            $this->uploadProgressImages($progressEntry, $request->file('progress_images'));
        }

        $progressEntry->load('progressImages');

        return $this->successResponse('Progress entry updated successfully', [
            'progress_entry' => $this->formatProgressEntry($progressEntry)
        ]);
    }

    /**
     * Delete progress entry
     */
    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        
        if ($user->role !== 'patient') {
            return $this->errorResponse('Only patients can delete their progress');
        }

        $patient = Patient::where('user_id', $user->id)->first();
        
        if (!$patient) {
            return $this->errorResponse('Patient profile not found');
        }

        $progressEntry = ProgressEntry::with('progressImages')
            ->where('patient_id', $patient->id)
            ->where('id', $id)
            ->first();

        if (!$progressEntry) {
            return $this->notFoundResponse('Progress entry not found');
        }

        // Delete all associated images
        foreach ($progressEntry->progressImages as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $progressEntry->delete();

        return $this->successResponse('Progress entry deleted successfully');
    }

    /**
     * Delete specific progress image
     */
    public function deleteImage(Request $request, $progressId, $imageId)
    {
        $user = $request->user();
        
        if ($user->role !== 'patient') {
            return $this->errorResponse('Only patients can delete their progress images');
        }

        $patient = Patient::where('user_id', $user->id)->first();
        
        if (!$patient) {
            return $this->errorResponse('Patient profile not found');
        }

        $progressEntry = ProgressEntry::where('patient_id', $patient->id)
            ->where('id', $progressId)
            ->first();

        if (!$progressEntry) {
            return $this->notFoundResponse('Progress entry not found');
        }

        $image = ProgressImage::where('progress_entry_id', $progressId)
            ->where('id', $imageId)
            ->first();

        if (!$image) {
            return $this->notFoundResponse('Progress image not found');
        }

        // Delete the file from storage
        Storage::disk('public')->delete($image->image_path);

        // Delete the database record
        $image->delete();

        return $this->successResponse('Progress image deleted successfully');
    }

    /**
     * Get progress statistics
     */
    public function statistics(Request $request)
    {
        $user = $request->user();
        
        if ($user->role !== 'patient') {
            return $this->errorResponse('Only patients can access their progress statistics');
        }

        $patient = Patient::where('user_id', $user->id)->first();
        
        if (!$patient) {
            return $this->errorResponse('Patient profile not found');
        }

        $progressEntries = ProgressEntry::where('patient_id', $patient->id)
            ->orderBy('measurement_date')
            ->get(['weight', 'measurement_date', 'waist', 'hips', 'chest']);

        if ($progressEntries->isEmpty()) {
            return $this->successResponse('No progress data available', [
                'statistics' => null
            ]);
        }

        $firstEntry = $progressEntries->first();
        $lastEntry = $progressEntries->last();

        $stats = [
            'total_entries' => $progressEntries->count(),
            'weight_change' => $lastEntry->weight - $firstEntry->weight,
            'initial_weight' => $firstEntry->weight,
            'current_weight' => $lastEntry->weight,
            'measurement_period' => [
                'start_date' => $firstEntry->measurement_date,
                'end_date' => $lastEntry->measurement_date,
            ],
        ];

        // Calculate measurement changes if available
        if ($firstEntry->waist && $lastEntry->waist) {
            $stats['waist_change'] = $lastEntry->waist - $firstEntry->waist;
        }
        if ($firstEntry->hips && $lastEntry->hips) {
            $stats['hips_change'] = $lastEntry->hips - $firstEntry->hips;
        }
        if ($firstEntry->chest && $lastEntry->chest) {
            $stats['chest_change'] = $lastEntry->chest - $firstEntry->chest;
        }

        return $this->successResponse('Progress statistics retrieved successfully', [
            'statistics' => $stats
        ]);
    }

    /**
     * Format progress entry for API response
     */
    private function formatProgressEntry($progressEntry)
    {
        return [
            'id' => $progressEntry->id,
            'weight' => $progressEntry->weight,
            'measurement_date' => $progressEntry->measurement_date,
            'notes' => $progressEntry->notes,
            
            // Measurements
            'measurements' => [
                'chest' => $progressEntry->chest,
                'left_arm' => $progressEntry->left_arm,
                'right_arm' => $progressEntry->right_arm,
                'waist' => $progressEntry->waist,
                'hips' => $progressEntry->hips,
                'left_thigh' => $progressEntry->left_thigh,
                'right_thigh' => $progressEntry->right_thigh,
            ],
            
            // Body composition
            'body_composition' => [
                'fat_mass' => $progressEntry->fat_mass,
                'muscle_mass' => $progressEntry->muscle_mass,
            ],
            
            // Images
            'images' => $progressEntry->progressImages->map(function ($image) {
                return [
                    'id' => $image->id,
                    'url' => Storage::disk('public')->url($image->image_path),
                    'path' => $image->image_path,
                ];
            }),
            
            'created_at' => $progressEntry->created_at,
            'updated_at' => $progressEntry->updated_at,
        ];
    }

    /**
     * Get validator for progress entry
     */
    private function getProgressValidator(Request $request, $isUpdate = false)
    {
        $rules = [
            // Required fields
            'weight' => 'required|numeric|min:0|max:999.99',
            'measurement_date' => 'required|date|date_format:Y-m-d|before_or_equal:today',
            
            // Optional measurement fields
            'chest' => 'nullable|numeric|min:0|max:999.99',
            'left_arm' => 'nullable|numeric|min:0|max:999.99',
            'right_arm' => 'nullable|numeric|min:0|max:999.99',
            'waist' => 'nullable|numeric|min:0|max:999.99',
            'hips' => 'nullable|numeric|min:0|max:999.99',
            'left_thigh' => 'nullable|numeric|min:0|max:999.99',
            'right_thigh' => 'nullable|numeric|min:0|max:999.99',
            
            // Body composition fields
            'fat_mass' => 'nullable|numeric|min:0|max:999.99',
            'muscle_mass' => 'nullable|numeric|min:0|max:999.99',
            
            // Other fields
            'notes' => 'nullable|string|max:2000',
            
            // Progress images
            'progress_images' => 'nullable|array|max:5',
            'progress_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120', // 5MB max per image
        ];

        // Add delete_images validation for updates
        if ($isUpdate) {
            $rules['delete_images'] = 'nullable|array';
            $rules['delete_images.*'] = 'exists:progress_images,id';
        }

        return Validator::make($request->all(), $rules);
    }

    /**
     * Upload progress images
     */
    private function uploadProgressImages(ProgressEntry $progressEntry, array $images)
    {
        foreach ($images as $image) {
            // Generate unique filename
            $filename = 'progress_' . $progressEntry->id . '_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            // Store in storage/app/public/progress_images
            $path = $image->storeAs('progress_images', $filename, 'public');
            
            // Create database record
            ProgressImage::create([
                'progress_entry_id' => $progressEntry->id,
                'image_path' => $path,
            ]);
        }
    }

    /**
     * Delete progress images by IDs
     */
    private function deleteProgressImages(array $imageIds)
    {
        $images = ProgressImage::whereIn('id', $imageIds)->get();
        
        foreach ($images as $image) {
            // Delete file from storage
            Storage::disk('public')->delete($image->image_path);
            
            // Delete database record
            $image->delete();
        }
    }
}