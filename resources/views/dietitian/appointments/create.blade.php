<x-app-layout title="Create Appointment" is-header-blur="true">
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <!-- Header + Breadcrumbs -->
        <div class="flex items-center space-x-4 py-5 lg:py-6">
            <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
                Create New Appointment
            </h2>
            <div class="hidden h-full py-1 sm:flex">
                <div class="h-full w-px bg-slate-300 dark:bg-navy-600"></div>
            </div>
            <ul class="hidden flex-wrap items-center space-x-2 sm:flex">
                <li class="flex items-center space-x-2">
                    <a href="{{ route('dietitian.dashboard') }}"
                       class="text-primary transition-colors hover:text-primary-focus dark:text-accent-light dark:hover:text-accent">
                        Dashboard
                    </a>
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </li>
                <li class="flex items-center space-x-2">
                    <a href="{{ route('dietitian.appointments.index') }}"
                       class="text-primary transition-colors hover:text-primary-focus dark:text-accent-light dark:hover:text-accent">
                        Appointments
                    </a>
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </li>
                <li>Create Appointment</li>
            </ul>
        </div>

        <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
            <div class="col-span-12">
                <div class="card" x-data="appointmentCreateForm()">
                    <div class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                        <div class="flex items-center space-x-3">
                            <div class="flex items-center justify-center size-10 rounded-full bg-primary/10 text-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                                    Schedule New Appointment
                                </h2>
                                <p class="text-sm text-slate-500 dark:text-navy-300">
                                    Book an appointment with an existing patient
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('dietitian.appointments.index') }}"
                            class="btn rounded-full border border-slate-300 font-medium text-slate-700 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back to Appointments
                        </a>
                    </div>
                    
                    <div class="p-4 sm:p-5">
                        @if($errors->any())
                        <div class="alert flex rounded-lg border border-error px-4 py-4 text-error sm:px-5 mb-5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 mr-3 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            <div>
                                <p class="font-medium mb-1">Please correct the following errors:</p>
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach($errors->all() as $error)
                                    <li class="text-sm">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif

                        <form method="POST" action="{{ route('dietitian.appointments.store') }}" 
                              @submit="handleSubmit" class="space-y-6">
                            @csrf
                            
                            <!-- Step 1: Patient Selection -->
                            <div class="space-y-6">
                                <div class="flex items-center space-x-3 mb-6">
                                    <div class="flex items-center justify-center size-8 rounded-full bg-blue-100 text-blue-600 dark:bg-blue-900/30">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-base font-semibold text-slate-800 dark:text-navy-50">Select Patient</h3>
                                        <p class="text-sm text-slate-500 dark:text-navy-300">Choose an existing patient for this appointment</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 gap-6">
                                    <!-- Patient Selection -->
                                    <label class="block">
                                        <span class="font-medium text-slate-700 dark:text-navy-100">Patient *</span>
                                        <select name="patient_id" x-model="selectedPatientId" @change="resetAvailableSlots()"
                                                class="form-select mt-2 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:bg-navy-700"
                                                required>
                                            <option value="">Select a patient...</option>
                                            @foreach($patients as $patient)
                                                <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                                    {{ $patient->user->name }} ({{ $patient->user->email }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($patients->isEmpty())
                                            <p class="mt-2 text-sm text-slate-500 dark:text-navy-300">
                                                No patients found. 
                                                <a href="{{ route('dietitian.patients.create') }}" class="text-primary hover:text-primary-focus">Create a patient first</a>
                                            </p>
                                        @endif
                                    </label>
                                </div>
                            </div>

                            <!-- Step 2: Appointment Details -->
                            <div class="space-y-6">
                                <div class="flex items-center space-x-3 mb-6">
                                    <div class="flex items-center justify-center size-8 rounded-full bg-green-100 text-green-600 dark:bg-green-900/30">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-base font-semibold text-slate-800 dark:text-navy-50">Appointment Details</h3>
                                        <p class="text-sm text-slate-500 dark:text-navy-300">Set the date, time, and type</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                    <!-- Appointment Type -->
                                    <label class="block">
                                        <span class="font-medium text-slate-700 dark:text-navy-100">Appointment Type *</span>
                                        <select name="appointment_type_id" x-model="selectedTypeId" @change="loadAvailableSlots()"
                                                class="form-select mt-2 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:bg-navy-700"
                                                required>
                                            <option value="">Select appointment type...</option>
                                            @foreach($appointmentTypes as $type)
                                                <option value="{{ $type->id }}" {{ old('appointment_type_id') == $type->id ? 'selected' : '' }}>
                                                    {{ $type->name }} ({{ $type->formatted_duration }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($appointmentTypes->isEmpty())
                                            <p class="mt-2 text-sm text-slate-500 dark:text-navy-300">
                                                No appointment types found. 
                                                <a href="{{ route('dietitian.appointment-types.index') }}" class="text-primary hover:text-primary-focus">Create appointment types first</a>
                                            </p>
                                        @endif
                                    </label>

                                    <!-- Appointment Date -->
                                    <label class="block">
                                        <span class="font-medium text-slate-700 dark:text-navy-100">Date *</span>
                                        <input type="date" name="appointment_date" x-model="selectedDate" @change="loadAvailableSlots()"
                                               value="{{ old('appointment_date', $selectedDate) }}"
                                               min="{{ date('Y-m-d') }}"
                                               class="form-input mt-2 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450"
                                               required>
                                    </label>

                                    <!-- Available Time Slots -->
                                    <div class="sm:col-span-2">
                                        <label class="block">
                                            <span class="font-medium text-slate-700 dark:text-navy-100">Available Time Slots *</span>
                                            <div class="mt-2">
                                                <!-- Loading State -->
                                                <div x-show="isLoadingSlots" class="flex items-center justify-center py-8">
                                                    <svg class="animate-spin size-6 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                    </svg>
                                                    <span class="ml-2 text-sm text-slate-600 dark:text-navy-300">Loading available slots...</span>
                                                </div>

                                                <!-- No Slots Available -->
                                                <div x-show="!isLoadingSlots && availableSlots.length === 0 && selectedDate && selectedTypeId" 
                                                     class="text-center py-8">
                                                    <div class="flex items-center justify-center size-12 rounded-full bg-slate-100 dark:bg-navy-600 mx-auto mb-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-slate-400 dark:text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                    </div>
                                                    <p class="text-slate-500 dark:text-navy-300 text-sm">No available slots for the selected date and time</p>
                                                    <p class="text-xs text-slate-400 dark:text-navy-400 mt-1">Try selecting a different date or check your availability settings</p>
                                                </div>

                                                <!-- Available Slots Grid -->
                                                <div x-show="!isLoadingSlots && availableSlots.length > 0" 
                                                     class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
                                                    <template x-for="slot in availableSlots" :key="slot.start_time">
                                                        <label class="relative cursor-pointer">
                                                            <input type="radio" name="start_time" :value="slot.start_time" x-model="selectedTime"
                                                                   class="sr-only" required>
                                                            <div class="rounded-lg border px-3 py-2 text-center text-sm font-medium transition-all"
                                                                 :class="selectedTime === slot.start_time ? 
                                                                    'border-primary bg-primary text-white dark:border-accent dark:bg-accent' : 
                                                                    'border-slate-300 bg-white text-slate-700 hover:border-primary hover:bg-primary/5 dark:border-navy-450 dark:bg-navy-700 dark:text-navy-100 dark:hover:border-accent dark:hover:bg-accent/5'">
                                                                <span x-text="slot.formatted_time"></span>
                                                            </div>
                                                        </label>
                                                    </template>
                                                </div>

                                                <!-- Instructions -->
                                                <div x-show="!selectedDate || !selectedTypeId" class="text-center py-8">
                                                    <p class="text-slate-500 dark:text-navy-300 text-sm">
                                                        Select appointment type and date to see available time slots
                                                    </p>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 3: Additional Information -->
                            <div class="space-y-6">
                                <div class="flex items-center space-x-3 mb-6">
                                    <div class="flex items-center justify-center size-8 rounded-full bg-purple-100 text-purple-600 dark:bg-purple-900/30">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-base font-semibold text-slate-800 dark:text-navy-50">Additional Information</h3>
                                        <p class="text-sm text-slate-500 dark:text-navy-300">Optional notes and details</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 gap-6">
                                    <!-- Notes -->
                                    <label class="block">
                                        <span class="font-medium text-slate-700 dark:text-navy-100">Notes</span>
                                        <textarea name="notes" rows="4"
                                                  class="form-textarea mt-2 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                  placeholder="Add any special notes or instructions for this appointment...">{{ old('notes') }}</textarea>
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Form Actions -->
                            <div class="flex justify-end space-x-3 pt-6 border-t border-slate-200 dark:border-navy-500">
                                <a href="{{ route('dietitian.appointments.index') }}"
                                    class="btn rounded-lg border border-slate-300 px-6 py-2.5 font-medium text-slate-700 hover:bg-slate-50 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-600 transition-all duration-200">
                                    Cancel
                                </a>
                                <button type="submit" :disabled="isSubmitting || !selectedPatientId || !selectedTypeId || !selectedDate || !selectedTime"
                                        class="btn rounded-lg bg-primary px-6 py-2.5 font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200">
                                    <span x-show="!isSubmitting" class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        Create Appointment
                                    </span>
                                    <span x-show="isSubmitting" class="flex items-center" style="display: none;">
                                        <svg class="animate-spin size-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Creating...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @slot('script')
        <script>
            function appointmentCreateForm() {
                return {
                    // Form state
                    isSubmitting: false,
                    isLoadingSlots: false,
                    
                    // Selected values
                    selectedPatientId: '{{ old("patient_id") }}',
                    selectedTypeId: '{{ old("appointment_type_id", $selectedAppointmentTypeId ?? "") }}',
                    selectedDate: '{{ old("appointment_date", $selectedDate ?? "") }}',
                    selectedTime: '{{ old("start_time", $selectedTime ?? "") }}',
                    
                    // Available slots
                    availableSlots: [],

                    // Initialize
                    init() {
                        // Load slots if we have pre-selected values (from calendar click)
                        if (this.selectedDate && this.selectedTypeId) {
                            this.loadAvailableSlots();
                        }
                    },

                    // Reset available slots
                    resetAvailableSlots() {
                        this.availableSlots = [];
                        this.selectedTime = '';
                    },

                    // Load available time slots
                    async loadAvailableSlots() {
                        if (!this.selectedDate || !this.selectedTypeId) {
                            this.resetAvailableSlots();
                            return;
                        }

                        this.isLoadingSlots = true;
                        this.selectedTime = '';

                        try {
                            const params = new URLSearchParams({
                                date: this.selectedDate,
                                appointment_type_id: this.selectedTypeId
                            });

                            const response = await fetch(`{{ route("dietitian.appointments.available-slots") }}?${params}`, {
                                method: 'GET',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'
                                }
                            });

                            if (!response.ok) {
                                throw new Error('Failed to load available slots');
                            }

                            const data = await response.json();
                            
                            if (data.success) {
                                this.availableSlots = data.available_slots || [];
                            } else {
                                console.error('Error loading slots:', data.message);
                                this.availableSlots = [];
                            }

                        } catch (error) {
                            console.error('Error loading available slots:', error);
                            this.availableSlots = [];
                        } finally {
                            this.isLoadingSlots = false;
                        }
                    },

                    // Handle form submission
                    handleSubmit(event) {
                        // Basic validation
                        if (!this.selectedPatientId || !this.selectedTypeId || !this.selectedDate || !this.selectedTime) {
                            event.preventDefault();
                            alert('Please fill in all required fields.');
                            return false;
                        }

                        // Prevent multiple submissions
                        if (this.isSubmitting) {
                            event.preventDefault();
                            return false;
                        }

                        this.isSubmitting = true;
                        return true;
                    }
                }
            }
        </script>
    @endslot
</x-app-layout>