<x-app-layout title="Edit Patient" is-header-blur="true">
    <!-- Main Content Wrapper -->
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="flex items-center space-x-4 py-5 lg:py-6">
            <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
                Edit Patient
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
                <li>Edit</li>
            </ul>
        </div>

        <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
            <div class="col-span-12">
                <div class="card">
                    <div class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                        <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                            Edit Patient Information
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

                        <form method="POST" action="{{ route('dietitian.patients.update', $patient->id) }}" class="mt-4">
                            @csrf
                            @method('PUT')
                            
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div class="space-y-4">
                                    <h3 class="text-base font-medium text-slate-700 dark:text-navy-100">
                                        Personal Information
                                    </h3>
                                    
                                    <label class="block">
                                        <span class="font-medium text-slate-600 dark:text-navy-100">Full Name</span>
                                        <input
                                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Patient's full name" type="text" name="name" value="{{ old('name', $patient->user->name) }}" required />
                                    </label>
                                    
                                    <label class="block">
                                        <span class="font-medium text-slate-600 dark:text-navy-100">Email Address</span>
                                        <input
                                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Email address" type="email" name="email" value="{{ old('email', $patient->user->email) }}" required />
                                    </label>
                                    
                                    <label class="block">
                                        <span class="font-medium text-slate-600 dark:text-navy-100">Phone Number</span>
                                        <input
                                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Phone number" type="text" name="phone" value="{{ old('phone', $patient->phone) }}" />
                                    </label>
                                    
                                    <label class="block">
                                        <span class="font-medium text-slate-600 dark:text-navy-100">Gender</span>
                                        <select
                                            class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                                            name="gender">
                                            <option value="">Select Gender</option>
                                            <option value="male" {{ (old('gender', $patient->gender) === 'male') ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ (old('gender', $patient->gender) === 'female') ? 'selected' : '' }}>Female</option>
                                            <option value="other" {{ (old('gender', $patient->gender) === 'other') ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </label>

                                    <label class="block">
                                        <span class="font-medium text-slate-600 dark:text-navy-100">Activity Level</span>
                                        <select
                                            class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                                            name="activity_level">
                                            <option value="">Select Activity Level</option>
                                            <option value="sedentary" {{ (old('activity_level', $patient->activity_level) === 'sedentary') ? 'selected' : '' }}>Sedentary (little or no exercise)</option>
                                            <option value="light" {{ (old('activity_level', $patient->activity_level) === 'light') ? 'selected' : '' }}>Light (light exercise 1-3 days/week)</option>
                                            <option value="moderate" {{ (old('activity_level', $patient->activity_level) === 'moderate') ? 'selected' : '' }}>Moderate (moderate exercise 3-5 days/week)</option>
                                            <option value="active" {{ (old('activity_level', $patient->activity_level) === 'active') ? 'selected' : '' }}>Active (hard exercise 6-7 days/week)</option>
                                            <option value="very_active" {{ (old('activity_level', $patient->activity_level) === 'very_active') ? 'selected' : '' }}>Very Active (very hard exercise & physical job)</option>
                                        </select>
                                    </label>
                                </div>
                                
                                <div class="space-y-4">
                                    <h3 class="text-base font-medium text-slate-700 dark:text-navy-100">
                                        Physical & Health Information
                                    </h3>
                                    
                                    <label class="block">
                                        <span class="font-medium text-slate-600 dark:text-navy-100">Height (cm)</span>
                                        <input
                                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Height in centimeters" type="number" step="0.1" min="0" name="height" value="{{ old('height', $patient->height) }}" />
                                    </label>
                                    
                                    <label class="block">
                                        <span class="font-medium text-slate-600 dark:text-navy-100">Initial Weight (kg)</span>
                                        <input
                                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Initial weight in kilograms" type="number" step="0.1" min="0" name="initial_weight" value="{{ old('initial_weight', $patient->initial_weight) }}" />
                                    </label>
                                    
                                    <label class="block">
                                        <span class="font-medium text-slate-600 dark:text-navy-100">Goal Weight (kg)</span>
                                        <input
                                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Goal weight in kilograms" type="number" step="0.1" min="0" name="goal_weight" value="{{ old('goal_weight', $patient->goal_weight) }}" />
                                    </label>
                                    
                                    <label class="block">
                                        <span class="font-medium text-slate-600 dark:text-navy-100">Medical Conditions</span>
                                        <textarea
                                            class="form-textarea mt-1.5 w-full resize-none rounded-lg border border-slate-300 bg-transparent p-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            rows="3" name="medical_conditions" placeholder="List any medical conditions">{{ old('medical_conditions', $patient->medical_conditions) }}</textarea>
                                    </label>
                                    
                                    <label class="block">
                                        <span class="font-medium text-slate-600 dark:text-navy-100">Allergies</span>
                                        <textarea
                                            class="form-textarea mt-1.5 w-full resize-none rounded-lg border border-slate-300 bg-transparent p-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            rows="3" name="allergies" placeholder="List any allergies">{{ old('allergies', $patient->allergies) }}</textarea>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="mt-6 space-y-4">
                                <h3 class="text-base font-medium text-slate-700 dark:text-navy-100">
                                    Additional Information
                                </h3>
                                
                                <label class="block">
                                    <span class="font-medium text-slate-600 dark:text-navy-100">Dietary Preferences</span>
                                    <textarea
                                        class="form-textarea mt-1.5 w-full resize-none rounded-lg border border-slate-300 bg-transparent p-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        rows="3" name="dietary_preferences" placeholder="Dietary preferences or restrictions">{{ old('dietary_preferences', $patient->dietary_preferences) }}</textarea>
                                </label>
                                
                                <label class="block">
                                    <span class="font-medium text-slate-600 dark:text-navy-100">Notes</span>
                                    <textarea
                                        class="form-textarea mt-1.5 w-full resize-none rounded-lg border border-slate-300 bg-transparent p-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        rows="4" name="notes" placeholder="Additional notes about the patient">{{ old('notes', $patient->notes) }}</textarea>
                                </label>
                            </div>
                            
                            <div class="mt-6 flex justify-end space-x-2">
                                <a href="{{ route('dietitian.patients.show', $patient->id) }}"
                                    class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-700 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                                    Cancel
                                </a>
                                <button type="submit"
                                    class="btn min-w-[7rem] rounded-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>