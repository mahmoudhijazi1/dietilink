<?php

namespace App\Http\Controllers\Web\Dietitian;

use App\Http\Controllers\Controller;
use App\Models\AppointmentType;
use Illuminate\Http\Request;

class AppointmentTypeController extends Controller
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

        // Get or create default appointment types if none exist
        $appointmentTypes = $dietitian->getOrCreateDefaultAppointmentTypes();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'appointment_types' => $appointmentTypes->map(function($type) {
                    return [
                        'id' => $type->id,
                        'name' => $type->name,
                        'duration_minutes' => $type->duration_minutes,
                        'formatted_duration' => $type->formatted_duration,
                        'color' => $type->color,
                        'description' => $type->description,
                        'is_active' => $type->is_active,
                        'sort_order' => $type->sort_order,
                        'can_be_deleted' => $type->canBeDeleted(),
                        'appointments_count' => $type->appointments()->count()
                    ];
                })
            ]);
        }

        return view('dietitian.appointment-types.index', compact('appointmentTypes'));
    }

    public function create()
    {
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'default_colors' => [
                    '#3B82F6', '#10B981', '#F59E0B', '#8B5CF6', 
                    '#EF4444', '#06B6D4', '#84CC16', '#F97316'
                ]
            ]);
        }

        return view('dietitian.appointment-types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'duration_minutes' => 'required|integer|min:5|max:480', // 5 minutes to 8 hours
            'color' => 'required|string|regex:/^#[a-fA-F0-9]{6}$/',
            'description' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0'
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

        // Check if name already exists for this dietitian
        $existingType = $dietitian->appointmentTypes()
            ->where('name', $request->name)
            ->first();

        if ($existingType) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An appointment type with this name already exists.',
                    'errors' => ['name' => ['An appointment type with this name already exists.']]
                ], 422);
            }
            return back()->withErrors(['name' => 'An appointment type with this name already exists.'])
                ->withInput();
        }

        // Set default sort order if not provided
        $sortOrder = $request->sort_order ?? ($dietitian->appointmentTypes()->max('sort_order') + 1);

        $appointmentType = $dietitian->appointmentTypes()->create([
            'name' => $request->name,
            'duration_minutes' => $request->duration_minutes,
            'color' => $request->color,
            'description' => $request->description,
            'sort_order' => $sortOrder
        ]);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Appointment type created successfully.',
                'appointment_type' => [
                    'id' => $appointmentType->id,
                    'name' => $appointmentType->name,
                    'duration_minutes' => $appointmentType->duration_minutes,
                    'formatted_duration' => $appointmentType->formatted_duration,
                    'color' => $appointmentType->color,
                    'description' => $appointmentType->description,
                    'is_active' => $appointmentType->is_active,
                    'sort_order' => $appointmentType->sort_order,
                    'can_be_deleted' => true,
                    'appointments_count' => 0
                ]
            ], 201);
        }

        return redirect()->route('dietitian.appointment-types.index')
            ->with('success', 'Appointment type created successfully.');
    }

    public function show(AppointmentType $appointmentType)
    {
        $dietitian = auth()->user()->dietitian;
        
        if (!$dietitian || $appointmentType->dietitian_id !== $dietitian->id) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Unauthorized access.'
                ], 403);
            }
            abort(403);
        }

        $appointmentsCount = $appointmentType->appointments()->count();
        $upcomingAppointments = $appointmentType->appointments()
            ->upcoming()
            ->with(['patient.user'])
            ->get();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'appointment_type' => [
                    'id' => $appointmentType->id,
                    'name' => $appointmentType->name,
                    'duration_minutes' => $appointmentType->duration_minutes,
                    'formatted_duration' => $appointmentType->formatted_duration,
                    'color' => $appointmentType->color,
                    'description' => $appointmentType->description,
                    'is_active' => $appointmentType->is_active,
                    'sort_order' => $appointmentType->sort_order,
                    'can_be_deleted' => $appointmentType->canBeDeleted(),
                    'appointments_count' => $appointmentsCount,
                    'upcoming_appointments_count' => $upcomingAppointments->count()
                ]
            ]);
        }

        return view('dietitian.appointment-types.show', compact('appointmentType', 'appointmentsCount', 'upcomingAppointments'));
    }

    public function edit(AppointmentType $appointmentType)
    {
        $dietitian = auth()->user()->dietitian;
        
        if (!$dietitian || $appointmentType->dietitian_id !== $dietitian->id) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Unauthorized access.'
                ], 403);
            }
            abort(403);
        }

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'appointment_type' => [
                    'id' => $appointmentType->id,
                    'name' => $appointmentType->name,
                    'duration_minutes' => $appointmentType->duration_minutes,
                    'color' => $appointmentType->color,
                    'description' => $appointmentType->description,
                    'is_active' => $appointmentType->is_active,
                    'sort_order' => $appointmentType->sort_order
                ],
                'default_colors' => [
                    '#3B82F6', '#10B981', '#F59E0B', '#8B5CF6', 
                    '#EF4444', '#06B6D4', '#84CC16', '#F97316'
                ]
            ]);
        }

        return view('dietitian.appointment-types.edit', compact('appointmentType'));
    }

    public function update(Request $request, AppointmentType $appointmentType)
    {
        $dietitian = auth()->user()->dietitian;
        
        if (!$dietitian || $appointmentType->dietitian_id !== $dietitian->id) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Unauthorized access.'
                ], 403);
            }
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'duration_minutes' => 'required|integer|min:5|max:480',
            'color' => 'required|string|regex:/^#[a-fA-F0-9]{6}$/',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0'
        ]);

        // Check if name already exists for this dietitian (excluding current type)
        $existingType = $dietitian->appointmentTypes()
            ->where('name', $request->name)
            ->where('id', '!=', $appointmentType->id)
            ->first();

        if ($existingType) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An appointment type with this name already exists.',
                    'errors' => ['name' => ['An appointment type with this name already exists.']]
                ], 422);
            }
            return back()->withErrors(['name' => 'An appointment type with this name already exists.'])
                ->withInput();
        }

        $appointmentType->update([
            'name' => $request->name,
            'duration_minutes' => $request->duration_minutes,
            'color' => $request->color,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => $request->sort_order ?? $appointmentType->sort_order
        ]);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Appointment type updated successfully.',
                'appointment_type' => [
                    'id' => $appointmentType->id,
                    'name' => $appointmentType->name,
                    'duration_minutes' => $appointmentType->duration_minutes,
                    'formatted_duration' => $appointmentType->formatted_duration,
                    'color' => $appointmentType->color,
                    'description' => $appointmentType->description,
                    'is_active' => $appointmentType->is_active,
                    'sort_order' => $appointmentType->sort_order,
                    'can_be_deleted' => $appointmentType->canBeDeleted(),
                    'appointments_count' => $appointmentType->appointments()->count()
                ]
            ]);
        }

        return redirect()->route('dietitian.appointment-types.index')
            ->with('success', 'Appointment type updated successfully.');
    }

    public function destroy(AppointmentType $appointmentType)
    {
        $dietitian = auth()->user()->dietitian;
        
        if (!$dietitian || $appointmentType->dietitian_id !== $dietitian->id) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Unauthorized access.'
                ], 403);
            }
            abort(403);
        }

        if (!$appointmentType->canBeDeleted()) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete appointment type that has existing appointments.',
                    'errors' => ['appointments' => ['This appointment type has existing appointments and cannot be deleted.']]
                ], 422);
            }
            return back()->withErrors(['appointments' => 'This appointment type has existing appointments and cannot be deleted.']);
        }

        $typeId = $appointmentType->id;
        $appointmentType->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Appointment type deleted successfully.',
                'deleted_id' => $typeId
            ]);
        }

        return redirect()->route('dietitian.appointment-types.index')
            ->with('success', 'Appointment type deleted successfully.');
    }

    /**
     * Update sort order of appointment types
     */
    public function updateSortOrder(Request $request)
    {
        $request->validate([
            'types' => 'required|array',
            'types.*.id' => 'required|integer|exists:appointment_types,id',
            'types.*.sort_order' => 'required|integer|min:0'
        ]);

        $dietitian = auth()->user()->dietitian;

        if (!$dietitian) {
            return response()->json([
                'success' => false, 
                'message' => 'Dietitian profile not found.'
            ], 404);
        }

        try {
            \DB::beginTransaction();

            foreach ($request->types as $typeData) {
                $appointmentType = AppointmentType::where('id', $typeData['id'])
                    ->where('dietitian_id', $dietitian->id)
                    ->first();

                if ($appointmentType) {
                    $appointmentType->update(['sort_order' => $typeData['sort_order']]);
                }
            }

            \DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Sort order updated successfully.'
            ]);

        } catch (\Exception $e) {
            \DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update sort order. Please try again.',
                'error' => app()->environment('local') ? $e->getMessage() : null
            ], 500);
        }
    }
}