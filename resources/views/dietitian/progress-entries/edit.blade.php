<x-app-layout title="Edit Progress Entry" is-header-blur="true">
    <!-- Main Content Wrapper -->
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="flex items-center space-x-4 py-5 lg:py-6">
            <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
                Edit Progress Entry
            </h2>
            <div class="hidden h-full py-1 sm:flex">
                <div class="h-full w-px bg-slate-300 dark:bg-navy-600"></div>
            </div>
            <ul class="hidden flex-wrap items-center space-x-2 sm:flex">
                <li class="flex items-center space-x-2">
                    <a class="text-primary transition-colors hover:text-primary-focus dark:text-accent-light dark:hover:text-accent"
                        href="{{ route('dietitian.dashboard') }}">Dashboard</a>
                    <svg x-ignore xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </li>
                <li class="flex items-center space-x-2">
                    <a class="text-primary transition-colors hover:text-primary-focus dark:text-accent-light dark:hover:text-accent"
                        href="{{ route('dietitian.patients.index') }}">Patients</a>
                    <svg x-ignore xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </li>
                <li class="flex items-center space-x-2">
                    <a class="text-primary transition-colors hover:text-primary-focus dark:text-accent-light dark:hover:text-accent"
                        href="{{ route('dietitian.patients.show', $patient->id) }}">{{ $patient->user->name }}</a>
                    <svg x-ignore xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </li>
                <li>Edit Progress</li>
            </ul>
        </div>

        <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
            <div class="col-span-12 lg:col-span-8">
                <div class="card">
                    <div class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                        <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                            Edit Progress Entry for {{ $patient->user->name }}
                        </h2>
                        <div class="flex justify-center space-x-2">
                            <a href="{{ route('dietitian.patients.show', $patient->id) }}"
                                class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-700 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                                Cancel
                            </a>
                        </div>
                    </div>
                    <div class="p-4 sm:p-5">
                        @if($errors->any())
                        <div class="alert flex rounded-lg border border-error px-4 py-4 text-error sm:px-5 mb-5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            <div>
                                <ul class="list-disc list-inside">
                                    @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif

                        <form method="POST" action="{{ route('dietitian.progress.update', ['patient' => $patient->id, 'progress' => $progressEntry->id]) }}" class="mt-4 space-y-5">
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <label class="block">
                                    <span class="font-medium text-slate-600 dark:text-navy-100">Weight (kg)</span>
                                    <input
                                        class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Weight in kilograms" type="number" step="0.1" min="0" name="weight" value="{{ old('weight', $progressEntry->weight) }}" required />
                                </label>
                                
                                <label class="block">
                                    <span class="font-medium text-slate-600 dark:text-navy-100">Measurement Date</span>
                                    <input
                                        class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        type="date" name="measurement_date" value="{{ old('measurement_date', $progressEntry->measurement_date->format('Y-m-d')) }}" required />
                                </label>
                            </div>

                            <!-- Optional Measurements -->
                            <div x-data="{ showMeasurements: {{ !empty($progressEntry->measurements) ? 'true' : 'false' }} }">
                                <div class="flex items-center space-x-2 mb-2">
                                    <button type="button" @click="showMeasurements = !showMeasurements" 
                                        class="btn h-9 rounded-full bg-slate-150 px-4 py-1 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                                        <span x-text="showMeasurements ? 'Hide Additional Measurements' : 'Add Additional Measurements'"></span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            :class="{ 'rotate-180': showMeasurements }">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                </div>
                                
                                <div x-show="showMeasurements" class="grid grid-cols-1 gap-4 sm:grid-cols-3 mt-4">
                                    <label class="block">
                                        <span class="font-medium text-slate-600 dark:text-navy-100">Chest (cm)</span>
                                        <input
                                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Chest measurement" type="number" step="0.1" min="0" name="measurements[chest]" value="{{ old('measurements.chest', $progressEntry->measurements['chest'] ?? '') }}" />
                                    </label>
                                    
                                    <label class="block">
                                        <span class="font-medium text-slate-600 dark:text-navy-100">Waist (cm)</span>
                                        <input
                                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Waist measurement" type="number" step="0.1" min="0" name="measurements[waist]" value="{{ old('measurements.waist', $progressEntry->measurements['waist'] ?? '') }}" />
                                    </label>
                                    
                                    <label class="block">
                                        <span class="font-medium text-slate-600 dark:text-navy-100">Hips (cm)</span>
                                        <input
                                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Hips measurement" type="number" step="0.1" min="0" name="measurements[hips]" value="{{ old('measurements.hips', $progressEntry->measurements['hips'] ?? '') }}" />
                                    </label>
                                    
                                    <label class="block">
                                        <span class="font-medium text-slate-600 dark:text-navy-100">Arms (cm)</span>
                                        <input
                                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Arms measurement" type="number" step="0.1" min="0" name="measurements[arms]" value="{{ old('measurements.arms', $progressEntry->measurements['arms'] ?? '') }}" />
                                    </label>
                                    
                                    <label class="block">
                                        <span class="font-medium text-slate-600 dark:text-navy-100">Thighs (cm)</span>
                                        <input
                                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Thighs measurement" type="number" step="0.1" min="0" name="measurements[thighs]" value="{{ old('measurements.thighs', $progressEntry->measurements['thighs'] ?? '') }}" />
                                    </label>
                                    
                                    <label class="block">
                                        <span class="font-medium text-slate-600 dark:text-navy-100">Body Fat %</span>
                                        <input
                                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Body fat percentage" type="number" step="0.1" min="0" max="100" name="measurements[body_fat]" value="{{ old('measurements.body_fat', $progressEntry->measurements['body_fat'] ?? '') }}" />
                                    </label>
                                </div>
                            </div>

                            <label class="block">
                                <span class="font-medium text-slate-600 dark:text-navy-100">Notes</span>
                                <textarea
                                    class="form-textarea mt-1.5 w-full resize-none rounded-lg border border-slate-300 bg-transparent p-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    rows="4" name="notes" placeholder="Notes about this progress entry">{{ old('notes', $progressEntry->notes) }}</textarea>
                            </label>
                            
                            <div class="mt-6 flex justify-end space-x-2">
                                <a href="{{ route('dietitian.patients.show', $patient->id) }}"
                                    class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-700 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                                    Cancel
                                </a>
                                <button type="submit"
                                    class="btn min-w-[7rem] rounded-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                    Update Progress
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-span-12 lg:col-span-4">
                <div class="card p-4 sm:p-5">
                    <div class="flex items-center space-x-4">
                        <div class="avatar size-14">
                            <div class="is-initial rounded-full bg-info text-lg uppercase text-white">
                                {{ substr($patient->user->name, 0, 1) }}
                            </div>
                        </div>
                        <div>
                            <h3 class="text-base font-medium text-slate-700 dark:text-navy-100">
                                {{ $patient->user->name }}
                            </h3>
                            <p class="text-xs+ text-slate-400 dark:text-navy-300">
                                @if($patient->user->status === 'active')
                                    <span class="text-success">Active Patient</span>
                                @elseif($patient->user->status === 'invited')
                                    <span class="text-warning">Invitation Pending</span>
                                @else
                                    <span class="text-error">{{ ucfirst($patient->user->status) }}</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="mt-5 space-y-4">
                        <div class="flex justify-between">
                            <div class="font-medium text-slate-600 dark:text-navy-100">Initial Weight</div>
                            <div>{{ $patient->initial_weight ?? 'Not recorded' }} {{ $patient->initial_weight ? 'kg' : '' }}</div>
                        </div>
                        <div class="flex justify-between">
                            <div class="font-medium text-slate-600 dark:text-navy-100">Goal Weight</div>
                            <div>{{ $patient->goal_weight ?? 'Not set' }} {{ $patient->goal_weight ? 'kg' : '' }}</div>
                        </div>
                        <div class="flex justify-between">
                            <div class="font-medium text-slate-600 dark:text-navy-100">Height</div>
                            <div>{{ $patient->height ?? 'Not recorded' }} {{ $patient->height ? 'cm' : '' }}</div>
                        </div>

                        <div class="my-3 h-px bg-slate-200 dark:bg-navy-500"></div>

                        <form method="POST" action="{{ route('dietitian.progress.destroy', ['patient' => $patient->id, 'progress' => $progressEntry->id]) }}" 
                            onsubmit="return confirm('Are you sure you want to delete this progress entry? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn w-full bg-error font-medium text-white hover:bg-error-focus focus:bg-error-focus active:bg-error-focus/90">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Delete Progress Entry
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>