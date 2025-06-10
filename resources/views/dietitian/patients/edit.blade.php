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
                <div class="card" x-data="{activeSection: 'personal', isSubmitting: false}">
                    <div class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                        <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                            Edit Patient Information
                        </h2>
                        
                        <!-- Progress Indicator -->
                        <div class="flex items-center space-x-2 text-sm">
                            <div class="flex items-center space-x-1">
                                <div class="size-2 rounded-full" :class="activeSection === 'personal' ? 'bg-primary' : 'bg-slate-300'"></div>
                                <span :class="activeSection === 'personal' ? 'text-primary font-medium' : 'text-slate-500'">Personal</span>
                            </div>
                            <div class="flex items-center space-x-1">
                                <div class="size-2 rounded-full" :class="activeSection === 'medical' ? 'bg-primary' : 'bg-slate-300'"></div>
                                <span :class="activeSection === 'medical' ? 'text-primary font-medium' : 'text-slate-500'">Medical</span>
                            </div>
                            <div class="flex items-center space-x-1">
                                <div class="size-2 rounded-full" :class="activeSection === 'food' ? 'bg-primary' : 'bg-slate-300'"></div>
                                <span :class="activeSection === 'food' ? 'text-primary font-medium' : 'text-slate-500'">Food History</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Section Navigation -->
                    <div class="border-b border-slate-200 dark:border-navy-500">
                        <div class="flex space-x-1 p-4 sm:px-5">
                            <button @click="activeSection = 'personal'" 
                                    class="btn rounded-lg px-4 py-2 text-sm font-medium transition-all duration-200"
                                    :class="activeSection === 'personal' ? 'bg-primary text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200 dark:bg-navy-600 dark:text-navy-100 dark:hover:bg-navy-500'">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Personal Info
                            </button>
                            <button @click="activeSection = 'medical'" 
                                    class="btn rounded-lg px-4 py-2 text-sm font-medium transition-all duration-200"
                                    :class="activeSection === 'medical' ? 'bg-primary text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200 dark:bg-navy-600 dark:text-navy-100 dark:hover:bg-navy-500'">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                                Medical History
                            </button>
                            <button @click="activeSection = 'food'" 
                                    class="btn rounded-lg px-4 py-2 text-sm font-medium transition-all duration-200"
                                    :class="activeSection === 'food' ? 'bg-primary text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200 dark:bg-navy-600 dark:text-navy-100 dark:hover:bg-navy-500'">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 002 2h1a2 2 0 002-2v-6"/>
                                </svg>
                                Food History
                            </button>
                        </div>
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

                        <form method="POST" action="{{ route('dietitian.patients.update', $patient->id) }}" 
                              @submit="isSubmitting = true" class="space-y-6">
                            @csrf
                            @method('PUT')
                            
                            <!-- Personal Information Section -->
                            <div x-show="activeSection === 'personal'" x-transition:enter="transition ease-out duration-200" 
                                 x-transition:enter-start="opacity-0 transform translate-x-4" 
                                 x-transition:enter-end="opacity-100 transform translate-x-0">
                                <div class="space-y-6">
                                    <div class="flex items-center space-x-3 mb-6">
                                        <div class="flex items-center justify-center size-10 rounded-full bg-primary/10 text-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-semibold text-slate-800 dark:text-navy-50">Personal Information</h3>
                                            <p class="text-sm text-slate-500 dark:text-navy-300">Basic contact and demographic information</p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                        <!-- Basic Info -->
                                        <div class="space-y-4">
                                            <label class="block">
                                                <span class="font-medium text-slate-700 dark:text-navy-100">Full Name *</span>
                                                <input
                                                    class="form-input mt-2 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
                                                    placeholder="Enter full name" type="text" name="name" value="{{ old('name', $patient->user->name) }}" required />
                                            </label>
                                            
                                            <label class="block">
                                                <span class="font-medium text-slate-700 dark:text-navy-100">Email Address *</span>
                                                <input
                                                    class="form-input mt-2 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
                                                    placeholder="Enter email address" type="email" name="email" value="{{ old('email', $patient->user->email) }}" required />
                                            </label>
                                            
                                            <label class="block">
                                                <span class="font-medium text-slate-700 dark:text-navy-100">Phone Number</span>
                                                <input
                                                    class="form-input mt-2 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
                                                    placeholder="Enter phone number" type="text" name="phone" value="{{ old('phone', $patient->phone) }}" />
                                            </label>
                                        </div>

                                        <!-- Demographics -->
                                        <div class="space-y-4">
                                            <label class="block">
                                                <span class="font-medium text-slate-700 dark:text-navy-100">Birth Date</span>
                                                <input
                                                    class="form-input mt-2 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
                                                    type="date" name="birth_date" value="{{ old('birth_date', $patient->birth_date) }}" />
                                            </label>
                                            
                                            <label class="block">
                                                <span class="font-medium text-slate-700 dark:text-navy-100">Gender</span>
                                                <select
                                                    class="form-select mt-2 w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
                                                    name="gender">
                                                    <option value="">Select Gender</option>
                                                    <option value="male" {{ (old('gender', $patient->gender) === 'male') ? 'selected' : '' }}>Male</option>
                                                    <option value="female" {{ (old('gender', $patient->gender) === 'female') ? 'selected' : '' }}>Female</option>
                                                    <option value="other" {{ (old('gender', $patient->gender) === 'other') ? 'selected' : '' }}>Other</option>
                                                </select>
                                            </label>
                                            
                                            <label class="block">
                                                <span class="font-medium text-slate-700 dark:text-navy-100">Occupation</span>
                                                <input
                                                    class="form-input mt-2 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
                                                    placeholder="Enter occupation" type="text" name="occupation" value="{{ old('occupation', $patient->occupation) }}" />
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Physical Measurements -->
                                    <div class="mt-8">
                                        <h4 class="text-base font-medium text-slate-700 dark:text-navy-100 mb-4">Physical Measurements</h4>
                                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                                            <label class="block">
                                                <span class="font-medium text-slate-700 dark:text-navy-100">Height (cm)</span>
                                                <input
                                                    class="form-input mt-2 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
                                                    placeholder="170" type="number" step="0.1" min="50" max="300" name="height" value="{{ old('height', $patient->height) }}" />
                                            </label>
                                            
                                            <label class="block">
                                                <span class="font-medium text-slate-700 dark:text-navy-100">Initial Weight (kg)</span>
                                                <input
                                                    class="form-input mt-2 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
                                                    placeholder="70" type="number" step="0.1" min="20" max="500" name="initial_weight" value="{{ old('initial_weight', $patient->initial_weight) }}" />
                                            </label>
                                            
                                            <label class="block">
                                                <span class="font-medium text-slate-700 dark:text-navy-100">Goal Weight (kg)</span>
                                                <input
                                                    class="form-input mt-2 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
                                                    placeholder="65" type="number" step="0.1" min="20" max="500" name="goal_weight" value="{{ old('goal_weight', $patient->goal_weight) }}" />
                                            </label>
                                        </div>
                                    </div>

                                    <label class="block">
                                        <span class="font-medium text-slate-700 dark:text-navy-100">Activity Level</span>
                                        <select
                                            class="form-select mt-2 w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
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
                            </div>

                            <!-- Medical History Section -->
                            <div x-show="activeSection === 'medical'" x-transition:enter="transition ease-out duration-200" 
                                 x-transition:enter-start="opacity-0 transform translate-x-4" 
                                 x-transition:enter-end="opacity-100 transform translate-x-0" style="display: none;">
                                <div class="space-y-6">
                                    <div class="flex items-center space-x-3 mb-6">
                                        <div class="flex items-center justify-center size-10 rounded-full bg-red-100 text-red-600 dark:bg-red-900/30">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-semibold text-slate-800 dark:text-navy-50">Medical History</h3>
                                            <p class="text-sm text-slate-500 dark:text-navy-300">Health conditions, medications, and medical background</p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                        <div class="space-y-4">
                                            <label class="block">
                                                <span class="font-medium text-slate-700 dark:text-navy-100">Chronic Diseases</span>
                                                <span class="text-xs text-slate-500 block mt-1">Diabetes, hypertension, kidney disease, thyroid, etc.</span>
                                                <textarea
                                                    class="form-textarea mt-2 w-full resize-none rounded-lg border border-slate-300 bg-transparent p-3 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
                                                    rows="3" name="medical_conditions" placeholder="List any chronic diseases or conditions">{{ old('medical_conditions', $patient->medical_conditions) }}</textarea>
                                            </label>
                                            
                                            <label class="block">
                                                <span class="font-medium text-slate-700 dark:text-navy-100">Current Medications</span>
                                                <textarea
                                                    class="form-textarea mt-2 w-full resize-none rounded-lg border border-slate-300 bg-transparent p-3 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
                                                    rows="3" name="medications" placeholder="List current medications and dosages">{{ old('medications', $patient->medications) }}</textarea>
                                            </label>
                                            
                                            <label class="block">
                                                <span class="font-medium text-slate-700 dark:text-navy-100">Previous Surgeries</span>
                                                <textarea
                                                    class="form-textarea mt-2 w-full resize-none rounded-lg border border-slate-300 bg-transparent p-3 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
                                                    rows="3" name="surgeries" placeholder="List any previous surgeries">{{ old('surgeries', $patient->surgeries) }}</textarea>
                                            </label>
                                        </div>

                                        <div class="space-y-4">
                                            <label class="block">
                                                <span class="font-medium text-slate-700 dark:text-navy-100">Food Allergies/Intolerances</span>
                                                <textarea
                                                    class="form-textarea mt-2 w-full resize-none rounded-lg border border-slate-300 bg-transparent p-3 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
                                                    rows="3" name="allergies" placeholder="List any food allergies or intolerances">{{ old('allergies', $patient->allergies) }}</textarea>
                                            </label>
                                            
                                            <label class="block">
                                                <span class="font-medium text-slate-700 dark:text-navy-100">Smoking Status</span>
                                                <textarea
                                                    class="form-textarea mt-2 w-full resize-none rounded-lg border border-slate-300 bg-transparent p-3 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
                                                    rows="2" name="smoking_status" placeholder="Current smoking status or history">{{ old('smoking_status', $patient->smoking_status) }}</textarea>
                                            </label>
                                            
                                            <label class="block">
                                                <span class="font-medium text-slate-700 dark:text-navy-100">GI Symptoms</span>
                                                <span class="text-xs text-slate-500 block mt-1">Constipation, bloating, heartburn, etc.</span>
                                                <textarea
                                                    class="form-textarea mt-2 w-full resize-none rounded-lg border border-slate-300 bg-transparent p-3 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
                                                    rows="2" name="gi_symptoms" placeholder="Any gastrointestinal symptoms">{{ old('gi_symptoms', $patient->gi_symptoms) }}</textarea>
                                            </label>
                                        </div>
                                    </div>

                                    <label class="block">
                                        <span class="font-medium text-slate-700 dark:text-navy-100">Recent Blood Tests</span>
                                        <span class="text-xs text-slate-500 block mt-1">Please describe recent blood test results if available</span>
                                        <textarea
                                            class="form-textarea mt-2 w-full resize-none rounded-lg border border-slate-300 bg-transparent p-3 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
                                            rows="3" name="recent_blood_test" placeholder="Recent blood test results and dates">{{ old('recent_blood_test', $patient->recent_blood_test) }}</textarea>
                                    </label>
                                </div>
                            </div>

                            <!-- Food History Section -->
                            <div x-show="activeSection === 'food'" x-transition:enter="transition ease-out duration-200" 
                                 x-transition:enter-start="opacity-0 transform translate-x-4" 
                                 x-transition:enter-end="opacity-100 transform translate-x-0" style="display: none;">
                                <div class="space-y-6">
                                    <div class="flex items-center space-x-3 mb-6">
                                        <div class="flex items-center justify-center size-10 rounded-full bg-green-100 text-green-600 dark:bg-green-900/30">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 002 2h1a2 2 0 002-2v-6"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-semibold text-slate-800 dark:text-navy-50">Food History</h3>
                                            <p class="text-sm text-slate-500 dark:text-navy-300">Dietary habits, lifestyle, and nutrition background</p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                        <div class="space-y-4">
                                            <label class="block">
                                                <span class="font-medium text-slate-700 dark:text-navy-100">Alcohol Intake</span>
                                                <textarea
                                                    class="form-textarea mt-2 w-full resize-none rounded-lg border border-slate-300 bg-transparent p-3 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
                                                    rows="2" name="alcohol_intake" placeholder="Frequency and amount of alcohol consumption">{{ old('alcohol_intake', $patient->alcohol_intake) }}</textarea>
                                            </label>
                                            
                                            <label class="block">
                                                <span class="font-medium text-slate-700 dark:text-navy-100">Coffee Intake</span>
                                                <textarea
                                                    class="form-textarea mt-2 w-full resize-none rounded-lg border border-slate-300 bg-transparent p-3 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
                                                    rows="2" name="coffee_intake" placeholder="Daily coffee consumption and timing">{{ old('coffee_intake', $patient->coffee_intake) }}</textarea>
                                            </label>
                                            
                                            <label class="block">
                                                <span class="font-medium text-slate-700 dark:text-navy-100">Vitamin Intake</span>
                                                <textarea
                                                    class="form-textarea mt-2 w-full resize-none rounded-lg border border-slate-300 bg-transparent p-3 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
                                                    rows="2" name="vitamin_intake" placeholder="Current vitamins and supplements">{{ old('vitamin_intake', $patient->vitamin_intake) }}</textarea>
                                            </label>
                                            
                                            <label class="block">
                                                <span class="font-medium text-slate-700 dark:text-navy-100">Previous Diets</span>
                                                <textarea
                                                    class="form-textarea mt-2 w-full resize-none rounded-lg border border-slate-300 bg-transparent p-3 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
                                                    rows="3" name="previous_diets" placeholder="Previous diet attempts and results">{{ old('previous_diets', $patient->previous_diets) }}</textarea>
                                            </label>
                                        </div>

                                        <div class="space-y-4">
                                            <label class="block">
                                                <span class="font-medium text-slate-700 dark:text-navy-100">Daily Routine</span>
                                                <span class="text-xs text-slate-500 block mt-1">Breakfast, snacks, dinner schedule</span>
                                                <textarea
                                                    class="form-textarea mt-2 w-full resize-none rounded-lg border border-slate-300 bg-transparent p-3 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
                                                    rows="3" name="daily_routine" placeholder="Describe typical daily eating routine">{{ old('daily_routine', $patient->daily_routine) }}</textarea>
                                            </label>
                                            
                                            <label class="block">
                                                <span class="font-medium text-slate-700 dark:text-navy-100">Physical Activity Details</span>
                                                <span class="text-xs text-slate-500 block mt-1">Type, days per week, duration</span>
                                                <textarea
                                                    class="form-textarea mt-2 w-full resize-none rounded-lg border border-slate-300 bg-transparent p-3 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
                                                    rows="3" name="physical_activity_details" placeholder="Detailed physical activity description">{{ old('physical_activity_details', $patient->physical_activity_details) }}</textarea>
                                            </label>
                                            
                                            <label class="block">
                                                <span class="font-medium text-slate-700 dark:text-navy-100">Weight History</span>
                                                <span class="text-xs text-slate-500 block mt-1">Highest and lowest weight in the last 5 years</span>
                                                <textarea
                                                    class="form-textarea mt-2 w-full resize-none rounded-lg border border-slate-300 bg-transparent p-3 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
                                                    rows="2" name="weight_history" placeholder="Weight fluctuations over the past 5 years">{{ old('weight_history', $patient->weight_history) }}</textarea>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 gap-6">
                                        <label class="block">
                                            <span class="font-medium text-slate-700 dark:text-navy-100">Dietary Preferences</span>
                                            <textarea
                                                class="form-textarea mt-2 w-full resize-none rounded-lg border border-slate-300 bg-transparent p-3 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
                                                rows="3" name="dietary_preferences" placeholder="Dietary preferences, restrictions, cultural considerations">{{ old('dietary_preferences', $patient->dietary_preferences) }}</textarea>
                                        </label>
                                        
                                        <label class="block">
                                            <span class="font-medium text-slate-700 dark:text-navy-100">Subscription Reason & Goals</span>
                                            <span class="text-xs text-slate-500 block mt-1">Why did you subscribe? What's your main goal?</span>
                                            <textarea
                                                class="form-textarea mt-2 w-full resize-none rounded-lg border border-slate-300 bg-transparent p-3 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
                                                rows="3" name="subscription_reason" placeholder="Goals and reasons for seeking nutrition guidance">{{ old('subscription_reason', $patient->subscription_reason) }}</textarea>
                                        </label>
                                        
                                        <label class="block">
                                            <span class="font-medium text-slate-700 dark:text-navy-100">Additional Notes</span>
                                            <textarea
                                                class="form-textarea mt-2 w-full resize-none rounded-lg border border-slate-300 bg-transparent p-3 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
                                                rows="3" name="notes" placeholder="Any additional notes or comments">{{ old('notes', $patient->notes) }}</textarea>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Navigation and Submit Buttons -->
                            <div class="flex justify-between items-center pt-6 border-t border-slate-200 dark:border-navy-500">
                                <div class="flex space-x-3">
                                    <button type="button" @click="activeSection = 'personal'" 
                                            x-show="activeSection !== 'personal'"
                                            class="btn rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-600 transition-all duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                        </svg>
                                        Previous
                                    </button>
                                    
                                    <button type="button" @click="activeSection = (activeSection === 'personal') ? 'medical' : 'food'" 
                                            x-show="activeSection !== 'food'"
                                            class="btn rounded-lg bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-200 dark:bg-navy-600 dark:text-navy-100 dark:hover:bg-navy-500 transition-all duration-200">
                                        Next
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </button>
                                </div>
                                
                                <div class="flex space-x-3">
                                    <a href="{{ route('dietitian.patients.show', $patient->id) }}"
                                        class="btn rounded-lg border border-slate-300 px-6 py-2.5 font-medium text-slate-700 hover:bg-slate-50 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-600 transition-all duration-200">
                                        Cancel
                                    </a>
                                    <button type="submit" :disabled="isSubmitting"
                                            class="btn rounded-lg bg-primary px-6 py-2.5 font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200">
                                        <span x-show="!isSubmitting" class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Save Changes
                                        </span>
                                        <span x-show="isSubmitting" class="flex items-center">
                                            <svg class="animate-spin size-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            Saving...
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>