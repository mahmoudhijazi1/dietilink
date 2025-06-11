<?php

namespace App\Http\Controllers\Web\Dietitian;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\ProgressEntry;
use App\Models\ProgressImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProgressEntryController extends Controller
{
    /**
     * Show the form for creating a new progress entry.
     */
    public function create($patientId)
    {
        $patient = Patient::with('user')->findOrFail($patientId);
        
        return view('dietitian.progress-entries.create', compact('patient'));
    }

    /**
     * Store a newly created progress entry.
     */
    public function store(Request $request, $patientId)
    {
        $patient = Patient::findOrFail($patientId);
        
        $validator = Validator::make($request->all(), [
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
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create the progress entry
        $progressEntry = ProgressEntry::create([
            'patient_id' => $patientId,
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

        return redirect()->route('dietitian.patients.show', $patientId)
            ->with('success', 'Progress entry added successfully!');
    }

    /**
     * Show the form for editing the specified progress entry.
     */
    public function edit($patientId, $id)
    {
        $patient = Patient::with('user')->findOrFail($patientId);
        $progressEntry = ProgressEntry::with('progressImages')->findOrFail($id);
        
        // Ensure the progress entry belongs to the specified patient
        if ($progressEntry->patient_id != $patientId) {
            abort(404);
        }
        
        return view('dietitian.progress-entries.edit', compact('patient', 'progressEntry'));
    }

    /**
     * Update the specified progress entry.
     */
    public function update(Request $request, $patientId, $id)
    {
        $patient = Patient::findOrFail($patientId);
        $progressEntry = ProgressEntry::findOrFail($id);
        
        // Ensure the progress entry belongs to the specified patient
        if ($progressEntry->patient_id != $patientId) {
            abort(404);
        }
        
        $validator = Validator::make($request->all(), [
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
            'progress_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120',
            
            // Images to delete
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'exists:progress_images,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
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

        return redirect()->route('dietitian.patients.show', $patientId)
            ->with('success', 'Progress entry updated successfully!');
    }

    /**
     * Remove the specified progress entry.
     */
    public function destroy($patientId, $id)
    {
        $progressEntry = ProgressEntry::with('progressImages')->findOrFail($id);
        
        // Ensure the progress entry belongs to the specified patient
        if ($progressEntry->patient_id != $patientId) {
            abort(404);
        }
        
        // Delete all associated images
        foreach ($progressEntry->progressImages as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }
        
        $progressEntry->delete();
        
        return redirect()->route('dietitian.patients.show', $patientId)
            ->with('success', 'Progress entry deleted successfully!');
    }

    /**
     * Delete a specific progress image
     */
    public function deleteImage(Request $request, $patientId, $progressId, $imageId)
    {
        $progressEntry = ProgressEntry::findOrFail($progressId);
        
        // Ensure the progress entry belongs to the specified patient
        if ($progressEntry->patient_id != $patientId) {
            abort(404);
        }
        
        $image = ProgressImage::where('progress_entry_id', $progressId)
                              ->where('id', $imageId)
                              ->firstOrFail();
        
        // Delete the file from storage
        Storage::disk('public')->delete($image->image_path);
        
        // Delete the database record
        $image->delete();
        
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
        
        return redirect()->back()->with('success', 'Image deleted successfully!');
    }

    /**
 * Upload progress images
 */
private function uploadProgressImages(ProgressEntry $progressEntry, array $images)
{
    foreach ($images as $image) {
        // Generate unique filename
        $filename = 'progress_' . $progressEntry->id . '_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        
        // Store in storage/app/public/progress_images (your correct way)
        $path = $image->storeAs('progress_images', $filename, 'public');
        
        // Create database record
        ProgressImage::create([
            'progress_entry_id' => $progressEntry->id,
            'image_path' => $path, // This will be: progress_images/filename.jpg
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
        // Delete file from storage/app/public
        Storage::disk('public')->delete($image->image_path);
        
        // Delete database record
        $image->delete();
    }
}
}