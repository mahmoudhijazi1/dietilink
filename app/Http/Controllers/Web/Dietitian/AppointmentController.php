<?php

namespace App\Http\Controllers\Web\Dietitian;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AppointmentType;
use App\Models\Patient;
use App\Models\User;
use App\Services\AvailableTimeSlotsService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    protected $availableTimeSlotsService;

    public function __construct(AvailableTimeSlotsService $availableTimeSlotsService)
    {
        $this->availableTimeSlotsService = $availableTimeSlotsService;
    }
    public function index(Request $request)
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

        $query = $dietitian->appointments()->with(['patient.user', 'appointmentType']);

        // Apply filters
        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        if ($request->filled('date_from')) {
            $query->where('appointment_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('appointment_date', '<=', $request->date_to);
        }

        if ($request->filled('patient_search')) {
            $query->whereHas('patient.user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->patient_search . '%')
                  ->orWhere('email', 'like', '%' . $request->patient_search . '%');
            });
        }

        // Default ordering
        $appointments = $query->orderBy('appointment_date', 'desc')
                             ->orderBy('start_time', 'desc')
                             ->paginate(15);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'appointments' => $appointments->map(function($appointment) {
                    return [
                        'id' => $appointment->id,
                        'patient_name' => $appointment->patient->user->name,
                        'patient_email' => $appointment->patient->user->email,
                        'appointment_type' => $appointment->appointmentType->name,
                        'appointment_date' => $appointment->appointment_date->format('Y-m-d'),
                        'formatted_date' => $appointment->formatted_date,
                        'start_time' => $appointment->start_time->format('H:i'),
                        'end_time' => $appointment->end_time->format('H:i'),
                        'formatted_time_range' => $appointment->formatted_time_range,
                        'status' => $appointment->status,
                        'notes' => $appointment->notes,
                        'duration_minutes' => $appointment->duration_minutes,
                        'can_be_canceled' => $appointment->can_be_canceled,
                        'can_be_rescheduled' => $appointment->can_be_rescheduled,
                        'can_be_completed' => $appointment->can_be_completed,
                        'color' => $appointment->appointmentType->color
                    ];
                }),
                'pagination' => [
                    'current_page' => $appointments->currentPage(),
                    'last_page' => $appointments->lastPage(),
                    'per_page' => $appointments->perPage(),
                    'total' => $appointments->total()
                ]
            ]);
        }

        $statusOptions = [
            'scheduled' => 'Scheduled',
            'completed' => 'Completed', 
            'canceled' => 'Canceled',
            'no_show' => 'No Show'
        ];

        return view('dietitian.appointments.index', compact('appointments', 'statusOptions'));
    }

    public function create(Request $request)
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

        $appointmentTypes = $dietitian->appointmentTypes()->active()->ordered()->get();
        
        // Get patients for this tenant
        $patients = Patient::whereHas('user', function($q) {
            $q->where('tenant_id', auth()->user()->tenant_id);
        })->with('user')->get();

        // If date and time are provided (from calendar click)
        $selectedDate = $request->date;
        $selectedTime = $request->time;
        $selectedAppointmentTypeId = $request->appointment_type_id;

        // Get available slots if date and appointment type are provided
        $availableSlots = [];
        if ($selectedDate && $selectedAppointmentTypeId) {
            $appointmentType = $appointmentTypes->find($selectedAppointmentTypeId);
            if ($appointmentType) {
                $availableSlots = $this->availableTimeSlotsService->getAvailableSlots(
                    $dietitian, 
                    $selectedDate, 
                    $appointmentType->duration_minutes
                );
            }
        }

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'appointment_types' => $appointmentTypes->map(function($type) {
                    return [
                        'id' => $type->id,
                        'name' => $type->name,
                        'duration_minutes' => $type->duration_minutes,
                        'formatted_duration' => $type->formatted_duration,
                        'color' => $type->color
                    ];
                }),
                'patients' => $patients->map(function($patient) {
                    return [
                        'id' => $patient->id,
                        'name' => $patient->user->name,
                        'email' => $patient->user->email,
                        'phone' => $patient->phone
                    ];
                }),
                'selected_date' => $selectedDate,
                'selected_time' => $selectedTime,
                'selected_appointment_type_id' => $selectedAppointmentTypeId,
                'available_slots' => $availableSlots
            ]);
        }

        return view('dietitian.appointments.create', compact(
            'appointmentTypes', 
            'patients', 
            'selectedDate', 
            'selectedTime', 
            'selectedAppointmentTypeId',
            'availableSlots'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_type_id' => 'required|exists:appointment_types,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'notes' => 'nullable|string|max:1000'
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

        // Verify appointment type belongs to this dietitian
        $appointmentType = $dietitian->appointmentTypes()->find($request->appointment_type_id);
        if (!$appointmentType) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid appointment type.',
                    'errors' => ['appointment_type_id' => ['Invalid appointment type.']]
                ], 422);
            }
            return back()->withErrors(['appointment_type_id' => 'Invalid appointment type.'])->withInput();
        }

        // Calculate end time based on appointment type duration
        $startTime = Carbon::parse($request->start_time);
        $endTime = $startTime->copy()->addMinutes($appointmentType->duration_minutes);

        // Create appointment instance for validation
        $appointment = new Appointment([
            'dietitian_id' => $dietitian->id,
            'patient_id' => $request->patient_id,
            'appointment_type_id' => $request->appointment_type_id,
            'appointment_date' => $request->appointment_date,
            'start_time' => $startTime->format('H:i'),
            'end_time' => $endTime->format('H:i'),
            'notes' => $request->notes,
            'created_by_user_id' => auth()->id()
        ]);

        // Check if appointment fits within availability using service
        if (!$this->availableTimeSlotsService->isTimeSlotAvailable(
            $dietitian, 
            $request->appointment_date, 
            $startTime->format('H:i'), 
            $appointmentType->duration_minutes
        )) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No availability found for the selected date and time.',
                    'errors' => ['availability' => ['No availability found for the selected date and time.']]
                ], 422);
            }
            return back()->withErrors(['availability' => 'No availability found for the selected date and time.'])->withInput();
        }

        // Check for overlapping appointments
        if ($appointment->overlapsWithExisting()) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This time slot conflicts with an existing appointment.',
                    'errors' => ['overlap' => ['This time slot conflicts with an existing appointment.']]
                ], 422);
            }
            return back()->withErrors(['overlap' => 'This time slot conflicts with an existing appointment.'])->withInput();
        }

        $appointment->save();

        // Load relationships for response
        $appointment->load(['patient.user', 'appointmentType']);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Appointment created successfully.',
                'appointment' => [
                    'id' => $appointment->id,
                    'patient_name' => $appointment->patient->user->name,
                    'appointment_type' => $appointment->appointmentType->name,
                    'appointment_date' => $appointment->appointment_date->format('Y-m-d'),
                    'formatted_date' => $appointment->formatted_date,
                    'start_time' => $appointment->start_time->format('H:i'),
                    'end_time' => $appointment->end_time->format('H:i'),
                    'formatted_time_range' => $appointment->formatted_time_range,
                    'status' => $appointment->status,
                    'notes' => $appointment->notes,
                    'color' => $appointment->appointmentType->color
                ]
            ], 201);
        }

        return redirect()->route('dietitian.appointments.index')
            ->with('success', 'Appointment created successfully.');
    }

    public function show(Appointment $appointment)
    {
        $dietitian = auth()->user()->dietitian;
        
        if (!$dietitian || $appointment->dietitian_id !== $dietitian->id) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Unauthorized access.'
                ], 403);
            }
            abort(403);
        }

        $appointment->load(['patient.user', 'appointmentType', 'createdBy', 'canceledBy']);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'appointment' => [
                    'id' => $appointment->id,
                    'patient' => [
                        'id' => $appointment->patient->id,
                        'name' => $appointment->patient->user->name,
                        'email' => $appointment->patient->user->email,
                        'phone' => $appointment->patient->phone
                    ],
                    'appointment_type' => [
                        'id' => $appointment->appointmentType->id,
                        'name' => $appointment->appointmentType->name,
                        'duration_minutes' => $appointment->appointmentType->duration_minutes,
                        'color' => $appointment->appointmentType->color
                    ],
                    'appointment_date' => $appointment->appointment_date->format('Y-m-d'),
                    'formatted_date' => $appointment->formatted_date,
                    'start_time' => $appointment->start_time->format('H:i'),
                    'end_time' => $appointment->end_time->format('H:i'),
                    'formatted_time_range' => $appointment->formatted_time_range,
                    'status' => $appointment->status,
                    'notes' => $appointment->notes,
                    'dietitian_notes' => $appointment->dietitian_notes,
                    'created_by' => $appointment->createdBy->name,
                    'created_at' => $appointment->created_at->format('M j, Y g:i A'),
                    'canceled_at' => $appointment->canceled_at?->format('M j, Y g:i A'),
                    'canceled_by' => $appointment->canceledBy?->name,
                    'cancellation_reason' => $appointment->cancellation_reason,
                    'can_be_canceled' => $appointment->can_be_canceled,
                    'can_be_rescheduled' => $appointment->can_be_rescheduled,
                    'can_be_completed' => $appointment->can_be_completed
                ]
            ]);
        }

        return view('dietitian.appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        $dietitian = auth()->user()->dietitian;
        
        if (!$dietitian || $appointment->dietitian_id !== $dietitian->id) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Unauthorized access.'
                ], 403);
            }
            abort(403);
        }

        if (!$appointment->can_be_rescheduled) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This appointment cannot be edited.'
                ], 422);
            }
            return redirect()->route('dietitian.appointments.show', $appointment)
                ->with('error', 'This appointment cannot be edited.');
        }

        $appointmentTypes = $dietitian->appointmentTypes()->active()->ordered()->get();
        $patients = Patient::whereHas('user', function($q) {
            $q->where('tenant_id', auth()->user()->tenant_id);
        })->with('user')->get();

        $appointment->load(['patient.user', 'appointmentType']);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'appointment' => [
                    'id' => $appointment->id,
                    'patient_id' => $appointment->patient_id,
                    'appointment_type_id' => $appointment->appointment_type_id,
                    'appointment_date' => $appointment->appointment_date->format('Y-m-d'),
                    'start_time' => $appointment->start_time->format('H:i'),
                    'notes' => $appointment->notes
                ],
                'appointment_types' => $appointmentTypes->map(function($type) {
                    return [
                        'id' => $type->id,
                        'name' => $type->name,
                        'duration_minutes' => $type->duration_minutes,
                        'formatted_duration' => $type->formatted_duration,
                        'color' => $type->color
                    ];
                }),
                'patients' => $patients->map(function($patient) {
                    return [
                        'id' => $patient->id,
                        'name' => $patient->user->name,
                        'email' => $patient->user->email,
                        'phone' => $patient->phone
                    ];
                })
            ]);
        }

        return view('dietitian.appointments.edit', compact('appointment', 'appointmentTypes', 'patients'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $dietitian = auth()->user()->dietitian;
        
        if (!$dietitian || $appointment->dietitian_id !== $dietitian->id) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Unauthorized access.'
                ], 403);
            }
            abort(403);
        }

        if (!$appointment->can_be_rescheduled) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This appointment cannot be edited.'
                ], 422);
            }
            return redirect()->route('dietitian.appointments.show', $appointment)
                ->with('error', 'This appointment cannot be edited.');
        }

        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_type_id' => 'required|exists:appointment_types,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'notes' => 'nullable|string|max:1000'
        ]);

        // Verify appointment type belongs to this dietitian
        $appointmentType = $dietitian->appointmentTypes()->find($request->appointment_type_id);
        if (!$appointmentType) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid appointment type.',
                    'errors' => ['appointment_type_id' => ['Invalid appointment type.']]
                ], 422);
            }
            return back()->withErrors(['appointment_type_id' => 'Invalid appointment type.'])->withInput();
        }

        // Store original data for rollback if needed
        $originalData = $appointment->only(['patient_id', 'appointment_type_id', 'appointment_date', 'start_time', 'end_time', 'notes']);

        // Calculate end time based on appointment type duration
        $startTime = Carbon::parse($request->start_time);
        $endTime = $startTime->copy()->addMinutes($appointmentType->duration_minutes);

        // Update appointment temporarily for validation
        $appointment->fill([
            'patient_id' => $request->patient_id,
            'appointment_type_id' => $request->appointment_type_id,
            'appointment_date' => $request->appointment_date,
            'start_time' => $startTime->format('H:i'),
            'end_time' => $endTime->format('H:i'),
            'notes' => $request->notes
        ]);

        // Check if appointment fits within availability using service
        if (!$this->availableTimeSlotsService->isTimeSlotAvailable(
            $dietitian, 
            $request->appointment_date, 
            $startTime->format('H:i'), 
            $appointmentType->duration_minutes,
            $appointment->id
        )) {
            $appointment->fill($originalData); // Restore original data
            
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No availability found for the selected date and time.',
                    'errors' => ['availability' => ['No availability found for the selected date and time.']]
                ], 422);
            }
            return back()->withErrors(['availability' => 'No availability found for the selected date and time.'])->withInput();
        }

        // Check for overlapping appointments
        if ($appointment->overlapsWithExisting()) {
            $appointment->fill($originalData); // Restore original data
            
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This time slot conflicts with an existing appointment.',
                    'errors' => ['overlap' => ['This time slot conflicts with an existing appointment.']]
                ], 422);
            }
            return back()->withErrors(['overlap' => 'This time slot conflicts with an existing appointment.'])->withInput();
        }

        $appointment->save();

        // Load relationships for response
        $appointment->load(['patient.user', 'appointmentType']);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Appointment updated successfully.',
                'appointment' => [
                    'id' => $appointment->id,
                    'patient_name' => $appointment->patient->user->name,
                    'appointment_type' => $appointment->appointmentType->name,
                    'appointment_date' => $appointment->appointment_date->format('Y-m-d'),
                    'formatted_date' => $appointment->formatted_date,
                    'start_time' => $appointment->start_time->format('H:i'),
                    'end_time' => $appointment->end_time->format('H:i'),
                    'formatted_time_range' => $appointment->formatted_time_range,
                    'status' => $appointment->status,
                    'notes' => $appointment->notes,
                    'color' => $appointment->appointmentType->color
                ]
            ]);
        }

        return redirect()->route('dietitian.appointments.show', $appointment)
            ->with('success', 'Appointment updated successfully.');
    }

    public function destroy(Appointment $appointment)
    {
        $dietitian = auth()->user()->dietitian;
        
        if (!$dietitian || $appointment->dietitian_id !== $dietitian->id) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Unauthorized access.'
                ], 403);
            }
            abort(403);
        }

        $appointmentId = $appointment->id;
        $appointment->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Appointment deleted successfully.',
                'deleted_id' => $appointmentId
            ]);
        }

        return redirect()->route('dietitian.appointments.index')
            ->with('success', 'Appointment deleted successfully.');
    }

    /**
     * Cancel an appointment
     */
    public function cancel(Request $request, Appointment $appointment)
    {
        $dietitian = auth()->user()->dietitian;
        
        if (!$dietitian || $appointment->dietitian_id !== $dietitian->id) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Unauthorized access.'
                ], 403);
            }
            abort(403);
        }

        if (!$appointment->can_be_canceled) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This appointment cannot be canceled.'
                ], 422);
            }
            return redirect()->route('dietitian.appointments.show', $appointment)
                ->with('error', 'This appointment cannot be canceled.');
        }

        $request->validate([
            'cancellation_reason' => 'nullable|string|max:500'
        ]);

        $appointment->cancel($request->cancellation_reason, auth()->id());

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Appointment canceled successfully.',
                'appointment' => [
                    'id' => $appointment->id,
                    'status' => $appointment->status,
                    'canceled_at' => $appointment->canceled_at->format('M j, Y g:i A'),
                    'cancellation_reason' => $appointment->cancellation_reason
                ]
            ]);
        }

        return redirect()->route('dietitian.appointments.show', $appointment)
            ->with('success', 'Appointment canceled successfully.');
    }

    /**
     * Mark appointment as completed
     */
    public function complete(Request $request, Appointment $appointment)
    {
        $dietitian = auth()->user()->dietitian;
        
        if (!$dietitian || $appointment->dietitian_id !== $dietitian->id) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Unauthorized access.'
                ], 403);
            }
            abort(403);
        }

        if (!$appointment->can_be_completed) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This appointment cannot be marked as completed.'
                ], 422);
            }
            return redirect()->route('dietitian.appointments.show', $appointment)
                ->with('error', 'This appointment cannot be marked as completed.');
        }

        $request->validate([
            'dietitian_notes' => 'nullable|string|max:1000'
        ]);

        $appointment->complete($request->dietitian_notes);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Appointment marked as completed.',
                'appointment' => [
                    'id' => $appointment->id,
                    'status' => $appointment->status,
                    'dietitian_notes' => $appointment->dietitian_notes
                ]
            ]);
        }

        return redirect()->route('dietitian.appointments.show', $appointment)
            ->with('success', 'Appointment marked as completed.');
    }

    /**
     * Mark appointment as no-show
     */
    public function markNoShow(Request $request, Appointment $appointment)
    {
        $dietitian = auth()->user()->dietitian;
        
        if (!$dietitian || $appointment->dietitian_id !== $dietitian->id) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Unauthorized access.'
                ], 403);
            }
            abort(403);
        }

        if (!$appointment->can_be_completed) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This appointment cannot be marked as no-show.'
                ], 422);
            }
            return redirect()->route('dietitian.appointments.show', $appointment)
                ->with('error', 'This appointment cannot be marked as no-show.');
        }

        $request->validate([
            'dietitian_notes' => 'nullable|string|max:1000'
        ]);

        $appointment->markNoShow($request->dietitian_notes);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Appointment marked as no-show.',
                'appointment' => [
                    'id' => $appointment->id,
                    'status' => $appointment->status,
                    'dietitian_notes' => $appointment->dietitian_notes
                ]
            ]);
        }

        return redirect()->route('dietitian.appointments.show', $appointment)
            ->with('success', 'Appointment marked as no-show.');
    }

    /**
     * Get available time slots for a specific date and appointment type
     */
    public function getAvailableSlots(Request $request)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'appointment_type_id' => 'required|exists:appointment_types,id'
        ]);

        $dietitian = auth()->user()->dietitian;
        
        if (!$dietitian) {
            return response()->json([
                'success' => false, 
                'message' => 'Dietitian profile not found.'
            ], 404);
        }

        // Verify appointment type belongs to this dietitian
        $appointmentType = $dietitian->appointmentTypes()->find($request->appointment_type_id);
        if (!$appointmentType) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid appointment type.'
            ], 422);
        }

        $availableSlots = $this->availableTimeSlotsService->getAvailableSlots(
            $dietitian, 
            $request->date, 
            $appointmentType->duration_minutes
        );

        return response()->json([
            'success' => true,
            'date' => $request->date,
            'appointment_type' => [
                'id' => $appointmentType->id,
                'name' => $appointmentType->name,
                'duration_minutes' => $appointmentType->duration_minutes
            ],
            'available_slots' => $availableSlots,
            'slots_count' => count($availableSlots)
        ]);
    }

    /**
     * Get available slots for a date range (for calendar view)
     */
    public function getAvailableSlotsForRange(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'appointment_type_id' => 'required|exists:appointment_types,id'
        ]);

        $dietitian = auth()->user()->dietitian;
        
        if (!$dietitian) {
            return response()->json([
                'success' => false, 
                'message' => 'Dietitian profile not found.'
            ], 404);
        }

        // Verify appointment type belongs to this dietitian
        $appointmentType = $dietitian->appointmentTypes()->find($request->appointment_type_id);
        if (!$appointmentType) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid appointment type.'
            ], 422);
        }

        $availableSlots = $this->availableTimeSlotsService->getAvailableSlotsForDateRange(
            $dietitian, 
            $request->start_date, 
            $request->end_date, 
            $appointmentType->duration_minutes
        );

        return response()->json([
            'success' => true,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'appointment_type' => [
                'id' => $appointmentType->id,
                'name' => $appointmentType->name,
                'duration_minutes' => $appointmentType->duration_minutes
            ],
            'available_slots_by_date' => $availableSlots
        ]);
    }

    /**
     * Get daily summary for calendar overview
     */
    public function getDailySummary(Request $request)
    {
        $request->validate([
            'date' => 'required|date'
        ]);

        $dietitian = auth()->user()->dietitian;
        
        if (!$dietitian) {
            return response()->json([
                'success' => false, 
                'message' => 'Dietitian profile not found.'
            ], 404);
        }

        $summary = $this->availableTimeSlotsService->getDailySummary($dietitian, $request->date);

        return response()->json([
            'success' => true,
            'summary' => $summary
        ]);
    }

    /**
     * Get next available appointment slot
     */
    public function getNextAvailableSlot(Request $request)
    {
        $request->validate([
            'appointment_type_id' => 'required|exists:appointment_types,id',
            'max_days_ahead' => 'nullable|integer|min:1|max:90'
        ]);

        $dietitian = auth()->user()->dietitian;
        
        if (!$dietitian) {
            return response()->json([
                'success' => false, 
                'message' => 'Dietitian profile not found.'
            ], 404);
        }

        // Verify appointment type belongs to this dietitian
        $appointmentType = $dietitian->appointmentTypes()->find($request->appointment_type_id);
        if (!$appointmentType) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid appointment type.'
            ], 422);
        }

        $nextSlot = $this->availableTimeSlotsService->getNextAvailableSlot(
            $dietitian, 
            $appointmentType->duration_minutes, 
            $request->max_days_ahead ?? 30
        );

        if (!$nextSlot) {
            return response()->json([
                'success' => false,
                'message' => 'No available slots found in the next ' . ($request->max_days_ahead ?? 30) . ' days.',
                'next_slot' => null
            ]);
        }

        return response()->json([
            'success' => true,
            'appointment_type' => [
                'id' => $appointmentType->id,
                'name' => $appointmentType->name,
                'duration_minutes' => $appointmentType->duration_minutes
            ],
            'next_slot' => $nextSlot
        ]);
    }
}