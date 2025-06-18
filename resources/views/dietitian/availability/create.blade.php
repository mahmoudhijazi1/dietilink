<x-app-layout title="Add Availability" is-header-blur="true">
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <!-- Breadcrumb -->
        <div class="flex items-center space-x-4 py-5 lg:py-6">
            <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
                {{ request('bulk') ? 'Bulk Edit Weekly Schedule' : 'Add Time Slot' }}
            </h2>
            <div class="hidden h-full py-1 sm:flex">
                <div class="h-full w-px bg-slate-300 dark:bg-navy-600"></div>
            </div>
            <ul class="hidden flex-wrap items-center space-x-2 sm:flex">
                <li class="flex items-center space-x-2">
                    <a href="{{ route('dietitian.dashboard') }}"
                        class="text-primary hover:text-primary-focus dark:text-accent-light dark:hover:text-accent">
                        Dashboard
                    </a>
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </li>
                <li class="flex items-center space-x-2">
                    <a href="{{ route('dietitian.availability.index') }}"
                        class="text-primary hover:text-primary-focus dark:text-accent-light dark:hover:text-accent">
                        Availability
                    </a>
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </li>
                <li>{{ request('bulk') ? 'Bulk Edit' : 'Add' }}</li>
            </ul>
        </div>

        <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
            <div class="col-span-12 lg:col-span-8">
                <div class="card">
                    <div class="flex items-center justify-between border-b border-slate-200 px-4 py-4 dark:border-navy-500 sm:px-5">
                        <h2 class="text-lg font-medium text-slate-700 dark:text-navy-100">
                            {{ request('bulk') ? 'Weekly Schedule Setup' : 'Time Slot Information' }}
                        </h2>
                        <a href="{{ route('dietitian.availability.index') }}"
                            class="btn rounded-full border border-slate-300 font-medium text-slate-700 hover:bg-slate-150 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-500">
                            Cancel
                        </a>
                    </div>

                    <div class="p-4 sm:p-5" x-data="availabilityForm()">
                        @if ($errors->any())
                            <div class="mb-4 rounded-lg bg-error/10 px-4 py-3 text-error dark:bg-error/15">
                                <ul class="space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(request('bulk'))
                            <!-- Bulk Edit Form -->
                            <form method="POST" action="{{ route('dietitian.availability.bulk-store') }}">
                                @csrf
                                
                                <div class="space-y-6">
                                    <template x-for="(day, dayIndex) in weekDays" :key="dayIndex">
                                        <div class="rounded-lg border border-slate-300 dark:border-navy-500 bg-slate-50 dark:bg-navy-800 overflow-hidden">
                                            <!-- Day Header -->
                                            <div class="flex items-center justify-between bg-slate-100 dark:bg-navy-700 px-4 py-3 border-b border-slate-200 dark:border-navy-600">
                                                <div class="flex items-center space-x-3">
                                                    <div class="flex items-center justify-center size-8 rounded-full bg-primary text-white text-sm font-medium">
                                                        <span x-text="day.name.charAt(0)"></span>
                                                    </div>
                                                    <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100" x-text="day.name"></h3>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <span class="text-sm text-slate-500 dark:text-navy-300" x-text="day.slots.length + ' slot(s)'"></span>
                                                    <button type="button" @click="addSlotToDay(dayIndex)"
                                                        class="btn size-8 rounded-full bg-primary text-white text-sm hover:bg-primary-focus">+</button>
                                                </div>
                                            </div>

                                            <!-- Time Slots -->
                                            <div class="p-4 space-y-4">
                                                <template x-for="(slot, slotIndex) in day.slots" :key="slotIndex">
                                                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3 items-end p-4 rounded-lg bg-white dark:bg-navy-700 border border-slate-200 dark:border-navy-600">
                                                        <!-- Hidden day input -->
                                                        <input type="hidden" :name="'availability[' + dayIndex + '][day_of_week]'" :value="day.number">
                                                        
                                                        <label class="block">
                                                            <span class="font-medium text-slate-600 dark:text-navy-100">Start Time</span>
                                                            <select x-model="slot.start_time" :name="'availability[' + dayIndex + '][slots][' + slotIndex + '][start_time]'"
                                                                class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 dark:border-navy-450 dark:bg-navy-700">
                                                                <option value="">Select start time</option>
                                                                @foreach($timeOptions as $time => $display)
                                                                    <option value="{{ $time }}">{{ $display }}</option>
                                                                @endforeach
                                                            </select>
                                                        </label>
                                                        
                                                        <label class="block">
                                                            <span class="font-medium text-slate-600 dark:text-navy-100">End Time</span>
                                                            <select x-model="slot.end_time" :name="'availability[' + dayIndex + '][slots][' + slotIndex + '][end_time]'"
                                                                class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 dark:border-navy-450 dark:bg-navy-700">
                                                                <option value="">Select end time</option>
                                                                @foreach($timeOptions as $time => $display)
                                                                    <option value="{{ $time }}">{{ $display }}</option>
                                                                @endforeach
                                                            </select>
                                                        </label>
                                                        
                                                        <div class="flex items-end">
                                                            <button type="button" @click="removeSlotFromDay(dayIndex, slotIndex)"
                                                                class="btn size-9 rounded-full bg-error text-white hover:bg-error-focus mb-1.5">−</button>
                                                        </div>
                                                    </div>
                                                </template>

                                                <!-- Add slot button when no slots exist -->
                                                <div x-show="day.slots.length === 0" class="text-center py-8">
                                                    <p class="text-slate-500 dark:text-navy-300 mb-3">No time slots for <span x-text="day.name"></span></p>
                                                    <button type="button" @click="addSlotToDay(dayIndex)"
                                                        class="btn rounded-full border border-primary text-primary hover:bg-primary/10 dark:border-accent dark:text-accent dark:hover:bg-accent/10">
                                                        + Add <span x-text="day.name"></span> Time Slot
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                <!-- Submit -->
                                <div class="pt-6 text-right">
                                    <button type="submit"
                                        class="btn bg-primary font-medium text-white hover:bg-primary-focus dark:bg-accent dark:hover:bg-accent-focus">
                                        Save Weekly Schedule
                                    </button>
                                </div>
                            </form>
                        @else
                            <!-- Single Slot Form -->
                            <form method="POST" action="{{ route('dietitian.availability.store') }}">
                                @csrf

                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <label class="block">
                                        <span class="font-medium text-slate-600 dark:text-navy-100">Day of Week</span>
                                        <select name="day_of_week" required
                                            class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 dark:border-navy-450 dark:bg-navy-700">
                                            <option value="" disabled {{ !request('day') ? 'selected' : '' }}>Select day</option>
                                            @foreach($daysOfWeek as $dayNumber => $dayName)
                                                <option value="{{ $dayNumber }}" {{ request('day') == $dayNumber ? 'selected' : '' }}>
                                                    {{ $dayName }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </label>
                                </div>

                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 mt-4">
                                    <label class="block">
                                        <span class="font-medium text-slate-600 dark:text-navy-100">Start Time</span>
                                        <select name="start_time" required
                                            class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 dark:border-navy-450 dark:bg-navy-700">
                                            <option value="" disabled selected>Select start time</option>
                                            @foreach($timeOptions as $time => $display)
                                                <option value="{{ $time }}">{{ $display }}</option>
                                            @endforeach
                                        </select>
                                    </label>
                                    
                                    <label class="block">
                                        <span class="font-medium text-slate-600 dark:text-navy-100">End Time</span>
                                        <select name="end_time" required
                                            class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 dark:border-navy-450 dark:bg-navy-700">
                                            <option value="" disabled selected>Select end time</option>
                                            @foreach($timeOptions as $time => $display)
                                                <option value="{{ $time }}">{{ $display }}</option>
                                            @endforeach
                                        </select>
                                    </label>
                                </div>

                                <!-- Submit -->
                                <div class="pt-6 text-right">
                                    <button type="submit"
                                        class="btn bg-primary font-medium text-white hover:bg-primary-focus dark:bg-accent dark:hover:bg-accent-focus">
                                        Add Time Slot
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Tips Card -->
            <div class="col-span-12 lg:col-span-4">
                <div class="card">
                    <div class="border-b border-slate-200 px-4 py-4 dark:border-navy-500 sm:px-5">
                        <h2 class="text-lg font-medium text-slate-700 dark:text-navy-100">
                            {{ request('bulk') ? 'Bulk Edit Tips' : 'Tips' }}
                        </h2>
                    </div>
                    <div class="p-4 sm:p-5 text-sm text-slate-600 dark:text-navy-300 space-y-2">
                        @if(request('bulk'))
                            <p><strong class="font-medium">Quick Setup:</strong> Set your entire weekly schedule at once.</p>
                            <p><strong class="font-medium">Multiple Slots:</strong> Add multiple time ranges per day for flexible scheduling.</p>
                            <p><strong class="font-medium">Save Time:</strong> This replaces your current weekly pattern completely.</p>
                        @else
                            <p><strong class="font-medium">Single Slot:</strong> Add one time slot to your schedule.</p>
                            <p><strong class="font-medium">No Overlaps:</strong> System prevents overlapping time slots automatically.</p>
                            <p><strong class="font-medium">Validation:</strong> End time must be after start time.</p>
                        @endif
                        <p><strong class="font-medium">Weekly Pattern:</strong> These slots repeat every week until you change them.</p>
                        <p><strong class="font-medium">Patient Booking:</strong> Only your available slots will be shown to patients.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Alpine.js Component Script -->
    <script>
        function availabilityForm() {
            return {
                weekDays: [
                    { name: 'Monday', number: 1, slots: [] },
                    { name: 'Tuesday', number: 2, slots: [] },
                    { name: 'Wednesday', number: 3, slots: [] },
                    { name: 'Thursday', number: 4, slots: [] },
                    { name: 'Friday', number: 5, slots: [] },
                    { name: 'Saturday', number: 6, slots: [] },
                    { name: 'Sunday', number: 0, slots: [] }
                ],

                addSlotToDay(dayIndex) {
                    this.weekDays[dayIndex].slots.push({
                        start_time: '',
                        end_time: ''
                    });
                },

                removeSlotFromDay(dayIndex, slotIndex) {
                    this.weekDays[dayIndex].slots.splice(slotIndex, 1);
                }
            };
        }
    </script>
</x-app-layout>