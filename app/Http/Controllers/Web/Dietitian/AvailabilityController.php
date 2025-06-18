<?php

namespace App\Http\Controllers\Web\Dietitian;

use App\Http\Controllers\Controller;
use App\Models\AvailabilitySlot;
use App\Models\Dietitian;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AvailabilityController extends Controller
{
    public function index()
    {
        $dietitian = auth()->user()->dietitian;
        
        if (!$dietitian) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Dietitian profile not found.'
                ], 404);
            }
            return redirect()->route('dietitian.dashboard')
                ->with('error', 'Dietitian profile not found.');
        }

        $weeklyAvailability = $dietitian->getWeeklyAvailability();
        $daysOfWeek = AvailabilitySlot::getDaysOfWeek();
        $timeOptions = AvailabilitySlot::getTimeOptions();

        if (request()->wantsJson()) {
            // Format for AJAX response
            $weeklySchedule = [];
            foreach ($daysOfWeek as $dayNumber => $dayName) {
                $slots = isset($weeklyAvailability[$dayNumber]) ? $weeklyAvailability[$dayNumber] : collect([]);
                $weeklySchedule[$dayNumber] = [
                    'name' => $dayName,
                    'slots' => $slots->map(function($slot) use ($dayNumber) {
                        return [
                            'id' => $slot['id'],
                            'day_of_week' => $dayNumber,
                            'start_time' => \Carbon\Carbon::parse($slot['start_time'])->format('H:i'),
                            'end_time' => \Carbon\Carbon::parse($slot['end_time'])->format('H:i'),
                        ];
                    })->toArray()
                ];
            }
            
            return response()->json([
                'success' => true,
                'weeklySchedule' => $weeklySchedule
            ]);
        }

        return view('dietitian.availability.index', compact('weeklyAvailability', 'daysOfWeek', 'timeOptions'));
    }

    public function create()
    {
        $daysOfWeek = AvailabilitySlot::getDaysOfWeek();
        $timeOptions = AvailabilitySlot::getTimeOptions();

        return view('dietitian.availability.create', compact('daysOfWeek', 'timeOptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'day_of_week' => 'required|integer|between:0,6',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $dietitian = auth()->user()->dietitian;

        if (!$dietitian) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Dietitian profile not found.'
                ], 404);
            }
            return redirect()->route('dietitian.dashboard')
                ->with('error', 'Dietitian profile not found.');
        }

        // Create new availability slot
        $availabilitySlot = new AvailabilitySlot([
            'dietitian_id' => $dietitian->id,
            'day_of_week' => $request->day_of_week,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        // Check for overlaps
        if ($availabilitySlot->overlapsWithExisting()) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This time slot overlaps with an existing availability.',
                    'errors' => ['overlap' => ['This time slot overlaps with an existing availability.']]
                ], 422);
            }
            return back()->withErrors(['overlap' => 'This time slot overlaps with an existing availability.'])
                ->withInput();
        }

        $availabilitySlot->save();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Availability slot added successfully.',
                'slot' => [
                    'id' => $availabilitySlot->id,
                    'day_of_week' => $availabilitySlot->day_of_week,
                    'start_time' => $availabilitySlot->start_time->format('H:i'),
                    'end_time' => $availabilitySlot->end_time->format('H:i'),
                    'formatted_range' => $availabilitySlot->formatted_time_range
                ]
            ]);
        }

        return redirect()->route('dietitian.availability.index')
            ->with('success', 'Availability slot added successfully.');
    }

    public function edit(AvailabilitySlot $availabilitySlot)
    {
        $dietitian = auth()->user()->dietitian;
        
        if (!$dietitian || $availabilitySlot->dietitian_id !== $dietitian->id) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Unauthorized access.'
                ], 403);
            }
            abort(403);
        }

        $daysOfWeek = AvailabilitySlot::getDaysOfWeek();
        $timeOptions = AvailabilitySlot::getTimeOptions();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'slot' => [
                    'id' => $availabilitySlot->id,
                    'day_of_week' => $availabilitySlot->day_of_week,
                    'start_time' => $availabilitySlot->start_time->format('H:i'),
                    'end_time' => $availabilitySlot->end_time->format('H:i'),
                    'day_name' => $availabilitySlot->day_name,
                    'formatted_range' => $availabilitySlot->formatted_time_range
                ],
                'daysOfWeek' => $daysOfWeek,
                'timeOptions' => $timeOptions
            ]);
        }

        return view('dietitian.availability.edit', compact('availabilitySlot', 'daysOfWeek', 'timeOptions'));
    }

    public function update(Request $request, AvailabilitySlot $availabilitySlot)
    {
        $dietitian = auth()->user()->dietitian;
        
        if (!$dietitian || $availabilitySlot->dietitian_id !== $dietitian->id) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Unauthorized access.'
                ], 403);
            }
            abort(403);
        }

        $request->validate([
            'day_of_week' => 'required|integer|between:0,6',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        // Update the slot temporarily to check for overlaps
        $originalData = $availabilitySlot->only(['day_of_week', 'start_time', 'end_time']);
        
        $availabilitySlot->fill([
            'day_of_week' => $request->day_of_week,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        // Check for overlaps
        if ($availabilitySlot->overlapsWithExisting()) {
            $availabilitySlot->fill($originalData); // Restore original data
            
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This time slot overlaps with an existing availability.',
                    'errors' => ['overlap' => ['This time slot overlaps with an existing availability.']]
                ], 422);
            }
            return back()->withErrors(['overlap' => 'This time slot overlaps with an existing availability.'])
                ->withInput();
        }

        $availabilitySlot->save();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Availability slot updated successfully.',
                'slot' => [
                    'id' => $availabilitySlot->id,
                    'day_of_week' => $availabilitySlot->day_of_week,
                    'start_time' => $availabilitySlot->start_time->format('H:i'),
                    'end_time' => $availabilitySlot->end_time->format('H:i'),
                    'formatted_range' => $availabilitySlot->formatted_time_range
                ]
            ]);
        }

        return redirect()->route('dietitian.availability.index')
            ->with('success', 'Availability slot updated successfully.');
    }

    public function destroy(AvailabilitySlot $availabilitySlot)
    {
        $dietitian = auth()->user()->dietitian;
        
        if (!$dietitian || $availabilitySlot->dietitian_id !== $dietitian->id) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Unauthorized access.'
                ], 403);
            }
            abort(403);
        }

        $slotId = $availabilitySlot->id;
        $availabilitySlot->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Availability slot deleted successfully.',
                'deletedId' => $slotId
            ]);
        }

        return redirect()->route('dietitian.availability.index')
            ->with('success', 'Availability slot deleted successfully.');
    }

    public function bulkStore(Request $request)
    {
        $request->validate([
            'availability' => 'required|array',
            'availability.*.day_of_week' => 'required|integer|between:0,6',
            'availability.*.slots' => 'required|array|min:1',
            'availability.*.slots.*.start_time' => 'required|date_format:H:i',
            'availability.*.slots.*.end_time' => 'required|date_format:H:i|after:availability.*.slots.*.start_time',
        ]);

        $dietitian = auth()->user()->dietitian;

        if (!$dietitian) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Dietitian profile not found.'
                ], 404);
            }
            return redirect()->route('dietitian.dashboard')
                ->with('error', 'Dietitian profile not found.');
        }

        try {
            // Start a database transaction
            \DB::beginTransaction();

            // Clear existing availability
            $dietitian->availabilitySlots()->delete();

            // Add new availability slots
            $createdSlots = [];
            foreach ($request->availability as $dayData) {
                foreach ($dayData['slots'] as $slot) {
                    $availabilitySlot = AvailabilitySlot::create([
                        'dietitian_id' => $dietitian->id,
                        'day_of_week' => $dayData['day_of_week'],
                        'start_time' => $slot['start_time'],
                        'end_time' => $slot['end_time'],
                    ]);
                    
                    $createdSlots[] = [
                        'id' => $availabilitySlot->id,
                        'day_of_week' => $availabilitySlot->day_of_week,
                        'start_time' => $availabilitySlot->start_time->format('H:i'),
                        'end_time' => $availabilitySlot->end_time->format('H:i'),
                        'formatted_range' => $availabilitySlot->formatted_time_range
                    ];
                }
            }

            \DB::commit();

            if (request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Weekly availability updated successfully.',
                    'slots' => $createdSlots
                ]);
            }

            return redirect()->route('dietitian.availability.index')
                ->with('success', 'Weekly availability updated successfully.');

        } catch (\Exception $e) {
            \DB::rollback();
            
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update weekly availability. Please try again.',
                    'error' => app()->environment('local') ? $e->getMessage() : null
                ], 500);
            }

            return redirect()->route('dietitian.availability.index')
                ->with('error', 'Failed to update weekly availability. Please try again.');
        }
    }

    /**
     * Get availability data for API/AJAX requests
     */
    public function getAvailabilityData()
    {
        $dietitian = auth()->user()->dietitian;
        
        if (!$dietitian) {
            return response()->json([
                'success' => false, 
                'message' => 'Dietitian profile not found.'
            ], 404);
        }

        $weeklyAvailability = $dietitian->getWeeklyAvailability();
        $daysOfWeek = AvailabilitySlot::getDaysOfWeek();
        $timeOptions = AvailabilitySlot::getTimeOptions();

        // Format for AJAX response
        $weeklySchedule = [];
        foreach ($daysOfWeek as $dayNumber => $dayName) {
            $slots = isset($weeklyAvailability[$dayNumber]) ? $weeklyAvailability[$dayNumber] : collect([]);
            $weeklySchedule[$dayNumber] = [
                'name' => $dayName,
                'slots' => $slots->map(function($slot) use ($dayNumber) {
                    return [
                        'id' => $slot['id'],
                        'day_of_week' => $dayNumber,
                        'start_time' => $slot['start_time'],
                        'end_time' => $slot['end_time'],
                        'formatted_range' => $slot['formatted_range']
                    ];
                })->toArray()
            ];
        }
        
        return response()->json([
            'success' => true,
            'weeklySchedule' => $weeklySchedule,
            'daysOfWeek' => $daysOfWeek,
            'timeOptions' => $timeOptions
        ]);
    }
}