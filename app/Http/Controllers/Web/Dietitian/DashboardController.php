<?php

namespace App\Http\Controllers\Web\Dietitian;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;
use App\Models\ProgressEntry;

class DashboardController extends Controller
{
    /**
     * Show the dashboard for the logged-in dietitian.
     */
    public function index()
    {
        $user = Auth::user();

        // Safety check
        if (!$user || $user->role !== 'dietitian') {
            abort(403, 'Unauthorized');
        }

        // Thanks to the global scope, this is already tenant-filtered
        $totalPatients = Patient::count();

        $latestProgressEntries = ProgressEntry::latest('measurement_date')
            ->with(['patient.user']) // Eager load for UI
            ->take(5)
            ->get();

        return view('dietitian.dashboard', [
            'totalPatients' => $totalPatients,
            'latestProgressEntries' => $latestProgressEntries,
        ]);
    }
}
