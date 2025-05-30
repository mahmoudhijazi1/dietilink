<?php

// app/Http/Controllers/Api/V1/PatientProgressController.php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProgressEntry;
use App\Models\Patient;

class PatientProgressController extends Controller
{
    // List all progress entries for the current patient
    public function index(Request $request)
    {
        $patient = $request->user()->patient;
        $progress = ProgressEntry::where('patient_id', $patient->id)
            ->orderByDesc('measurement_date')
            ->get();

        return response()->json($progress);
    }

    // Store new progress entry
    public function store(Request $request)
    {
        $patient = $request->user()->patient;

        $data = $request->validate([
            'weight' => ['nullable', 'numeric', 'min:0'],
            'measurements' => ['nullable', 'array'],
            'notes' => ['nullable', 'string'],
            'measurement_date' => ['required', 'date'],
        ]);

        $entry = ProgressEntry::create([
            'patient_id' => $patient->id,
            'weight' => $data['weight'] ?? null,
            'measurements' => $data['measurements'] ?? null,
            'notes' => $data['notes'] ?? null,
            'measurement_date' => $data['measurement_date'],
        ]);

        return response()->json($entry, 201);
    }

    // (Optional) Show latest progress entry
    public function latest(Request $request)
    {
        $patient = $request->user()->patient;
        $entry = ProgressEntry::where('patient_id', $patient->id)
            ->orderByDesc('measurement_date')
            ->first();

        return response()->json($entry);
    }
}
