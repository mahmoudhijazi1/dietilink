<?php

namespace App\Http\Controllers\Web\Dietitian;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\ProgressEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
            'weight' => 'required|numeric|min:0',
            'measurement_date' => 'required|date|date_format:Y-m-d|before_or_equal:today',
            'notes' => 'nullable|string',
            'measurements' => 'nullable|array',
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
            'measurements' => $request->measurements ?: null,
        ]);

        return redirect()->route('dietitian.patients.show', $patientId)
            ->with('success', 'Progress entry added successfully!');
    }

    /**
     * Show the form for editing the specified progress entry.
     */
    public function edit($patientId, $id)
    {
        $patient = Patient::with('user')->findOrFail($patientId);
        $progressEntry = ProgressEntry::findOrFail($id);
        
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
            'weight' => 'required|numeric|min:0',
            'measurement_date' => 'required|date|date_format:Y-m-d|before_or_equal:today',
            'notes' => 'nullable|string',
            'measurements' => 'nullable|array',
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
            'measurements' => $request->measurements ?: null,
        ]);

        return redirect()->route('dietitian.patients.show', $patientId)
            ->with('success', 'Progress entry updated successfully!');
    }

    /**
     * Remove the specified progress entry.
     */
    public function destroy($patientId, $id)
    {
        $progressEntry = ProgressEntry::findOrFail($id);
        
        // Ensure the progress entry belongs to the specified patient
        if ($progressEntry->patient_id != $patientId) {
            abort(404);
        }
        
        $progressEntry->delete();
        
        return redirect()->route('dietitian.patients.show', $patientId)
            ->with('success', 'Progress entry deleted successfully!');
    }
}