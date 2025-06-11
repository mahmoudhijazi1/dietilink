<x-app-layout title="Patient Details" is-header-blur="true">
    <!-- Main Content Wrapper -->
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="flex items-center space-x-4 py-5 lg:py-6">
            <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
                Patient Details
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
                <li>{{ $patient->user->name }}</li>
            </ul>
        </div>

        <!-- Flash Message -->
        @if(session('success'))
        <div class="alert flex rounded-lg border border-success px-4 py-4 text-success sm:px-5 mb-5">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd" />
            </svg>
            <span>&nbsp;{{ session('success') }}</span>
        </div>
        @endif

        <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
            <!-- Enhanced Patient Info Card -->
            <div class="col-span-12 lg:col-span-4">
                <div class="card p-4 sm:p-5">
                <div class="flex items-center space-x-4">
                    <div class="avatar size-20">
                        <div class="is-initial rounded-full bg-info text-2xl uppercase text-white">
                            {{ substr($patient->user->name, 0, 1) }}
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100">
                            {{ $patient->user->name }}
                        </h3>
                        <p class="text-xs+ space-x-2">
                            @if($patient->user->status === 'active')
                                <span class="text-success">Active Patient</span>
                            @elseif($patient->user->status === 'invited')
                                <span class="text-warning">Invitation Pending</span>
                            @else
                                <span class="text-error">{{ ucfirst($patient->user->status) }}</span>
                            @endif
                            
                            @if($patient->birth_date)
                                <span class="text-slate-500">•</span>
                                <span class="text-slate-600 dark:text-navy-300">
                                    {{ \Carbon\Carbon::parse($patient->birth_date)->age }} years
                                </span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="mt-6 space-y-4">
                    <!-- Contact Information -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-slate-400 dark:text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span class="font-medium">Email</span>
                        </div>
                        <span class="text-sm">{{ $patient->user->email }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-slate-400 dark:text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span class="font-medium">Phone</span>
                        </div>
                        <span class="text-sm">{{ $patient->phone ?? 'Not provided' }}</span>
                    </div>

                    <!-- Personal Info -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-slate-400 dark:text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span class="font-medium">Gender</span>
                        </div>
                        <span class="text-sm">{{ $patient->gender ? ucfirst($patient->gender) : 'Not specified' }}</span>
                    </div>
                    
                    @if($patient->occupation)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-slate-400 dark:text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6.344M16 6H8m8 0l2 2-2 2m-8-4l-2 2 2 2"/>
                            </svg>
                            <span class="font-medium">Occupation</span>
                        </div>
                        <span class="text-sm">{{ $patient->occupation }}</span>
                    </div>
                    @endif

                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-slate-400 dark:text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                            <span class="font-medium">Status</span>
                        </div>
                        @if($patient->user->status === 'active')
                            <div class="badge bg-success/10 text-success dark:bg-success/15">Active</div>
                        @elseif($patient->user->status === 'invited')
                            <div class="badge bg-warning/10 text-warning dark:bg-warning/15">Invited</div>
                        @else
                            <div class="badge bg-error/10 text-error dark:bg-error/15">{{ ucfirst($patient->user->status) }}</div>
                        @endif
                    </div>

                    <div class="my-3 h-px bg-slate-200 dark:bg-navy-500"></div>
                    
                    <!-- Physical Measurements -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-slate-400 dark:text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                            </svg>
                            <span class="font-medium">Height</span>
                        </div>
                        <span class="text-sm">{{ $patient->height ?? 'Not recorded' }} {{ $patient->height ? 'cm' : '' }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-slate-400 dark:text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="font-medium">Initial Weight</span>
                        </div>
                        <span class="text-sm">{{ $patient->initial_weight ?? 'Not recorded' }} {{ $patient->initial_weight ? 'kg' : '' }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-slate-400 dark:text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            <span class="font-medium">Goal Weight</span>
                        </div>
                        <span class="text-sm">{{ $patient->goal_weight ?? 'Not set' }} {{ $patient->goal_weight ? 'kg' : '' }}</span>
                    </div>

                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-slate-400 dark:text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                            </svg>
                            <span class="font-medium">Activity Level</span>
                        </div>
                        <span class="text-sm">{{ $patient->activity_level ? ucfirst(str_replace('_', ' ', $patient->activity_level)) : 'Not specified' }}</span>
                    </div>
                    <!-- Enhanced BMI Calculation with Latest Weight -->
                    @if($bmiData)
                        <div class="flex items-center justify-between ">
                            <div class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-slate-400 dark:text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                <span class="font-medium">Current BMI</span>
                            </div>
                            <div class="text-right">
                                <div class="text-sm">
                                    <span class="font-medium">{{ $bmiData['current'] }}</span>
                                    <span class="{{ $bmiData['color'] }} ml-1">({{ $bmiData['category'] }})</span>
                                </div>
                                @if($bmiData['change'])
                                    <div class="text-xs text-slate-500 dark:text-navy-400">
                                        @if($bmiData['change'] > 0)
                                            <span class="text-red-500">+{{ $bmiData['change'] }}</span> from initial
                                        @elseif($bmiData['change'] < 0)
                                            <span class="text-green-500">{{ $bmiData['change'] }}</span> from initial
                                        @else
                                            No change from initial
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- BMI Comparison Card (if there's progress data) -->
                        @if($patient->progressEntries && $patient->progressEntries->count() > 0 && $bmiData['initial'])
                            <div class="mt-3 p-3 rounded-lg bg-slate-50/50 dark:bg-navy-600/25 border border-slate-200 dark:border-navy-500">
                                <h5 class="text-xs font-medium text-slate-600 dark:text-navy-300 mb-2">BMI Progress</h5>
                                <div class="grid grid-cols-3 gap-3 text-xs">
                                    <div class="text-center">
                                        <div class="font-medium text-slate-800 dark:text-navy-50">{{ $bmiData['initial'] }}</div>
                                        <div class="text-slate-500 dark:text-navy-400">Initial</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="font-medium text-slate-800 dark:text-navy-50">{{ $bmiData['current'] }}</div>
                                        <div class="text-slate-500 dark:text-navy-400">Current</div>
                                    </div>
                                    <div class="text-center">
                                        @if($bmiData['change'])
                                            <div class="font-medium {{ $bmiData['change'] < 0 ? 'text-green-600' : 'text-red-500' }}">
                                                {{ $bmiData['change'] > 0 ? '+' : '' }}{{ $bmiData['change'] }}
                                            </div>
                                            <div class="text-slate-500 dark:text-navy-400">Change</div>
                                        @else
                                            <div class="font-medium text-slate-500">-</div>
                                            <div class="text-slate-500 dark:text-navy-400">Change</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-2 text-xs text-slate-600 dark:text-navy-300">
                                    Based on current weight: {{ $bmiData['current_weight'] }} kg
                                </div>
                            </div>
                        @endif
                    @elseif($patient->height && $patient->initial_weight)
                        <!-- Fallback to old method if no progress entries -->
                        @php
                            $heightInMeters = $patient->height / 100;
                            $bmi = round($patient->initial_weight / ($heightInMeters * $heightInMeters), 1);
                            $bmiCategory = '';
                            $bmiColor = '';
                            if ($bmi < 18.5) {
                                $bmiCategory = 'Underweight';
                                $bmiColor = 'text-blue-600';
                            } elseif ($bmi < 25) {
                                $bmiCategory = 'Normal';
                                $bmiColor = 'text-success';
                            } elseif ($bmi < 30) {
                                $bmiCategory = 'Overweight';
                                $bmiColor = 'text-warning';
                            } else {
                                $bmiCategory = 'Obese';
                                $bmiColor = 'text-error';
                            }
                        @endphp
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-slate-400 dark:text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                <span class="font-medium">Initial BMI</span>
                            </div>
                            <span class="text-sm">
                                <span class="font-medium">{{ $bmi }}</span>
                                <span class="{{ $bmiColor }} ml-1">({{ $bmiCategory }})</span>
                            </span>
                        </div>
                    @endif
                </div>
                
                <!-- Action Buttons -->
                <div class="mt-6 flex justify-center space-x-2">
                    <a href="{{ route('dietitian.patients.edit', $patient->id) }}"
                        class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-700 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Profile
                    </a>
                    <button onclick="confirmDelete({{ $patient->id }})"
                        class="btn min-w-[7rem] rounded-full bg-error font-medium text-white hover:bg-error-focus focus:bg-error-focus active:bg-error-focus/90">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Delete
                    </button>
                </div>
            </div>
        </div>

<!-- Updated Tabs Section with New Medical History Tab -->
<div class="col-span-12 lg:col-span-8">
    <div class="card" x-data="{activeTab:'mealPlansTab'}">
        <div class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
            <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                Patient Information
            </h2>
            <!-- Responsive tab buttons -->
            <div class="w-full sm:w-auto overflow-x-auto">
                <div class="flex justify-center sm:justify-end gap-2 min-w-max px-2 sm:px-0">
                    <button @click="activeTab = 'mealPlansTab'" 
                            class="btn min-w-[5rem] sm:min-w-[6rem] rounded-full text-xs sm:text-sm flex-shrink-0" 
                            :class="activeTab === 'mealPlansTab' ? 'bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90' : 'border border-slate-300 font-medium text-slate-700 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90'">
                        <span class="hidden sm:inline">Meal Plans</span>
                        <span class="sm:hidden">Meals</span>
                    </button>
                    <button @click="activeTab = 'progressTab'" 
                            class="btn min-w-[5rem] sm:min-w-[6rem] rounded-full text-xs sm:text-sm flex-shrink-0" 
                            :class="activeTab === 'progressTab' ? 'bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90' : 'border border-slate-300 font-medium text-slate-700 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90'">
                        Progress
                    </button>
                    <button @click="activeTab = 'medicalTab'" 
                            class="btn min-w-[5rem] sm:min-w-[6rem] rounded-full text-xs sm:text-sm flex-shrink-0" 
                            :class="activeTab === 'medicalTab' ? 'bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90' : 'border border-slate-300 font-medium text-slate-700 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90'">
                        <span class="hidden sm:inline">Medical</span>
                        <span class="sm:hidden">Med</span>
                    </button>
                    <button @click="activeTab = 'foodHistoryTab'" 
                            class="btn min-w-[5rem] sm:min-w-[6rem] rounded-full text-xs sm:text-sm flex-shrink-0" 
                            :class="activeTab === 'foodHistoryTab' ? 'bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90' : 'border border-slate-300 font-medium text-slate-700 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90'">
                        <span class="hidden sm:inline">Food History</span>
                        <span class="sm:hidden">Food</span>
                    </button>
                    <button @click="activeTab = 'notesTab'" 
                            class="btn min-w-[5rem] sm:min-w-[6rem] rounded-full text-xs sm:text-sm flex-shrink-0" 
                            :class="activeTab === 'notesTab' ? 'bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90' : 'border border-slate-300 font-medium text-slate-700 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90'">
                        Notes
                    </button>
                </div>
            </div>
        
                    </div>

                    <!-- Meal Plans Tab -->
                    <div x-show="activeTab === 'mealPlansTab'" class="p-4 sm:p-5" x-data="mealPlansManager()">
                        <div class="flex justify-between mb-5">
                            <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100">
                                Meal Plans
                            </h3>
                            <a href="{{ route('dietitian.meal-plans.create') }}?patient_id={{ $patient->id }}" class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Create New Plan
                            </a>
                        </div>

                        <!-- Active Meal Plan -->
                        @php
                            $activePlan = $patient->mealPlans->where('status', 'active')->first();
                        @endphp

                        @if($activePlan)
                            <div class="mb-6 rounded-lg border-2 border-success bg-success/5 p-4 dark:bg-success/10">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex items-center justify-center size-10 rounded-full bg-success text-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="text-lg font-semibold text-slate-800 dark:text-navy-50">{{ $activePlan->name }}</h4>
                                            <p class="text-sm text-success">Currently Active Plan</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('dietitian.meal-plans.show', $activePlan->id) }}" 
                                           class="btn size-8 rounded-full p-0 hover:bg-success/20 text-success">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                        <a href="{{ route('dietitian.meal-plans.edit', $activePlan->id) }}" 
                                           class="btn size-8 rounded-full p-0 hover:bg-info/20 text-info">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>

                                <!-- Active Plan Summary -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                    <div class="flex items-center space-x-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-slate-600 dark:text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="text-sm">Created {{ $activePlan->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-slate-600 dark:text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                        <span class="text-sm">{{ $activePlan->meals->count() }} meals configured</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-slate-600 dark:text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                        </svg>
                                        <span class="text-sm">{{ $activePlan->meals->sum(function($meal) { return $meal->mealItems->count(); }) }} food items</span>
                                    </div>
                                </div>

                                @if($activePlan->notes)
                                    <div class="mt-3 p-3 rounded-lg bg-white/50 dark:bg-navy-700/50">
                                        <p class="text-sm text-slate-700 dark:text-navy-200">{{ $activePlan->notes }}</p>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="mb-6 rounded-lg border-2 border-dashed border-slate-300 p-8 text-center dark:border-navy-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-12 mx-auto text-slate-400 dark:text-navy-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                <h4 class="text-lg font-medium text-slate-700 dark:text-navy-100 mb-2">No Active Meal Plan</h4>
                                <p class="text-slate-500 dark:text-navy-300 mb-4">This patient doesn't have an active meal plan yet.</p>
                                <a href="{{ route('dietitian.meal-plans.create') }}?patient_id={{ $patient->id }}" class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                    Create First Meal Plan
                                </a>
                            </div>
                        @endif

                        <!-- Other Meal Plans -->
                        @php
                            $otherPlans = $patient->mealPlans->where('status', '!=', 'active');
                        @endphp

                        @if($otherPlans->count() > 0)
                            <div class="space-y-4">
                                <h4 class="text-base font-medium text-slate-700 dark:text-navy-100">Other Meal Plans ({{ $otherPlans->count() }})</h4>
                                
                                <div class="space-y-3">
                                    @foreach($otherPlans as $plan)
                                        <div class="flex items-center justify-between p-4 rounded-lg border border-slate-200 dark:border-navy-600 bg-white dark:bg-navy-800">
                                            <div class="flex items-center space-x-4">
                                                <div class="flex items-center justify-center size-10 rounded-full {{ $plan->status === 'draft' ? 'bg-warning/10 text-warning' : 'bg-slate-100 text-slate-600 dark:bg-navy-600 dark:text-navy-300' }}">
                                                    @if($plan->status === 'draft')
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                        </svg>
                                                    @else
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                                                        </svg>
                                                    @endif
                                                </div>
                                                <div>
                                                    <h5 class="font-medium text-slate-800 dark:text-navy-50">{{ $plan->name }}</h5>
                                                    <div class="flex items-center space-x-4 text-sm text-slate-500 dark:text-navy-300">
                                                        <span>{{ ucfirst($plan->status) }}</span>
                                                        <span>•</span>
                                                        <span>{{ $plan->meals->count() }} meals</span>
                                                        <span>•</span>
                                                        <span>{{ $plan->created_at->format('M d, Y') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <button @click="activatePlan({{ $plan->id }})" 
                                                        :disabled="isLoading"
                                                        class="btn size-8 rounded-full p-0 hover:bg-success/20 text-success disabled:opacity-50 disabled:cursor-not-allowed"
                                                        title="Make Active">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                </button>
                                                <a href="{{ route('dietitian.meal-plans.show', $plan->id) }}" 
                                                   class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 text-slate-600 dark:text-navy-300">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                </a>
                                                <a href="{{ route('dietitian.meal-plans.edit', $plan->id) }}" 
                                                   class="btn size-8 rounded-full p-0 hover:bg-info/20 text-info">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                </a>
                                                <button @click="deletePlan({{ $plan->id }})" 
                                                        :disabled="isLoading"
                                                        class="btn size-8 rounded-full p-0 hover:bg-error/20 text-error disabled:opacity-50 disabled:cursor-not-allowed"
                                                        title="Delete Plan">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
<!-- Progress Tab -->
<div x-show="activeTab === 'progressTab'" class="p-4 sm:p-5" style="display: none;">
    <div class="flex justify-between mb-5">
        <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100">
            Progress Tracking
        </h3>
        <a href="{{ route('dietitian.progress.create', $patient->id) }}" class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add Progress Entry
        </a>
    </div>

    @if($patient->progressEntries && $patient->progressEntries->count() > 0)
        <!-- Progress Statistics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            @php
                $latestEntry = $patient->progressEntries->first();
                $firstEntry = $patient->progressEntries->last();
                $totalWeightChange = $latestEntry->weight - $firstEntry->weight;
                $progressCount = $patient->progressEntries->count();
                
                // Count entries with measurements
                $entriesWithMeasurements = $patient->progressEntries->filter(function($entry) {
                    return $entry->chest || $entry->waist || $entry->hips || $entry->left_arm || $entry->right_arm || $entry->left_thigh || $entry->right_thigh;
                })->count();
                
                // Count entries with images
                $entriesWithImages = $patient->progressEntries->filter(function($entry) {
                    return $entry->progressImages && $entry->progressImages->count() > 0;
                })->count();
            @endphp
            
            <div class="card p-4">
                <div class="flex items-center space-x-3">
                    <div class="flex items-center justify-center size-10 rounded-full bg-blue-100 text-blue-600 dark:bg-blue-900/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-slate-600 dark:text-navy-300">Current Weight</h4>
                        <p class="text-lg font-semibold text-slate-800 dark:text-navy-50">{{ $latestEntry->weight }} kg</p>
                        <p class="text-xs text-slate-500 dark:text-navy-400">{{ $latestEntry->measurement_date->format('M d') }}</p>
                    </div>
                </div>
            </div>

            <div class="card p-4">
                <div class="flex items-center space-x-3">
                    <div class="flex items-center justify-center size-10 rounded-full {{ $totalWeightChange >= 0 ? 'bg-red-100 text-red-600 dark:bg-red-900/30' : 'bg-green-100 text-green-600 dark:bg-green-900/30' }}">
                        @if($totalWeightChange >= 0)
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/>
                            </svg>
                        @endif
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-slate-600 dark:text-navy-300">Total Change</h4>
                        <p class="text-lg font-semibold {{ $totalWeightChange >= 0 ? 'text-red-600' : 'text-green-600' }}">
                            {{ $totalWeightChange >= 0 ? '+' : '' }}{{ number_format($totalWeightChange, 1) }} kg
                        </p>
                        <p class="text-xs text-slate-500 dark:text-navy-400">{{ $progressCount }} entries</p>
                    </div>
                </div>
            </div>

            <div class="card p-4">
                <div class="flex items-center space-x-3">
                    <div class="flex items-center justify-center size-10 rounded-full bg-purple-100 text-purple-600 dark:bg-purple-900/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-slate-600 dark:text-navy-300">Measurements</h4>
                        <p class="text-lg font-semibold text-slate-800 dark:text-navy-50">{{ $entriesWithMeasurements }}</p>
                        <p class="text-xs text-slate-500 dark:text-navy-400">entries tracked</p>
                    </div>
                </div>
            </div>

            @if($patient->goal_weight)
            <div class="card p-4">
                <div class="flex items-center space-x-3">
                    @php
                        $remaining = $latestEntry->weight - $patient->goal_weight;
                        $isGainGoal = $patient->goal_weight > ($patient->initial_weight ?? $latestEntry->weight);
                    @endphp
                    <div class="flex items-center justify-center size-10 rounded-full bg-orange-100 text-orange-600 dark:bg-orange-900/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-slate-600 dark:text-navy-300">To Goal</h4>
                        <p class="text-lg font-semibold text-slate-800 dark:text-navy-50">
                            {{ abs($remaining) }} kg
                        </p>
                        <p class="text-xs text-slate-500 dark:text-navy-400">
                            {{ $isGainGoal ? ($remaining < 0 ? 'to gain' : 'over goal') : ($remaining > 0 ? 'to lose' : 'achieved!') }}
                        </p>
                    </div>
                </div>
            </div>
            @else
            <div class="card p-4">
                <div class="flex items-center space-x-3">
                    <div class="flex items-center justify-center size-10 rounded-full bg-indigo-100 text-indigo-600 dark:bg-indigo-900/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-slate-600 dark:text-navy-300">Progress Photos</h4>
                        <p class="text-lg font-semibold text-slate-800 dark:text-navy-50">{{ $entriesWithImages }}</p>
                        <p class="text-xs text-slate-500 dark:text-navy-400">with images</p>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Weight Progress Chart -->
        <div class="card mb-6">
            <div class="border-b border-slate-200 px-4 py-4 dark:border-navy-500 sm:px-5">
                <div class="flex items-center space-x-2">
                    <div class="flex items-center justify-center size-7 rounded-full bg-primary/10 text-primary dark:bg-accent-light/10 dark:text-accent-light">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h4 class="text-lg font-medium text-slate-700 dark:text-navy-100">Weight Progress Chart</h4>
                </div>
            </div>
            <div class="p-4 sm:p-5">
                <div style="height: 400px;">
                    <canvas id="weightChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Progress Entries List with Accordion Style -->
        <div class="space-y-4" x-data="{ openEntry: null }">
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-lg font-medium text-slate-700 dark:text-navy-100">Progress History</h4>
                <div class="flex items-center space-x-2 text-xs text-slate-500 dark:text-navy-300">
                    <span>{{ $progressCount }} entries</span>
                    <span>•</span>
                    <span>Latest: {{ $latestEntry->measurement_date->format('M d, Y') }}</span>
                </div>
            </div>
            
            @foreach($patient->progressEntries as $index => $entry)
                @php
                    $previousEntry = $patient->progressEntries->where('measurement_date', '<', $entry->measurement_date)->sortByDesc('measurement_date')->first();
                    $weightChange = $previousEntry ? $entry->weight - $previousEntry->weight : 0;
                    $hasMeasurements = $entry->chest || $entry->waist || $entry->hips || $entry->left_arm || $entry->right_arm || $entry->left_thigh || $entry->right_thigh;
                    $hasComposition = $entry->fat_mass || $entry->muscle_mass;
                    $hasImages = $entry->progressImages && $entry->progressImages->count() > 0;
                @endphp
                
                <div class="card overflow-hidden">
                    <!-- Entry Header -->
                    <div class="flex items-center justify-between p-4 cursor-pointer hover:bg-slate-50 dark:hover:bg-navy-600/50 transition-colors duration-200"
                         @click="openEntry = openEntry === {{ $index }} ? null : {{ $index }}">
                        <div class="flex items-center space-x-4">
                            <!-- Date Badge -->
                            <div class="flex flex-col items-center">
                                @if($index === 0)
                                    <div class="size-3 rounded-full bg-primary animate-pulse mb-1"></div>
                                @endif
                                <div class="text-center">
                                    <div class="text-sm font-semibold text-slate-800 dark:text-navy-50">
                                        {{ $entry->measurement_date->format('M d') }}
                                    </div>
                                    <div class="text-xs text-slate-500 dark:text-navy-300">
                                        {{ $entry->measurement_date->format('Y') }}
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Weight Info -->
                            <div class="flex items-center space-x-4">
                                <div>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-2xl font-bold text-slate-800 dark:text-navy-50">{{ $entry->weight }}</span>
                                        <span class="text-sm text-slate-500 dark:text-navy-300">kg</span>
                                        @if($index === 0)
                                            <span class="badge bg-primary/10 text-primary text-xs">Latest</span>
                                        @endif
                                    </div>
                                    
                                    @if($weightChange != 0)
                                        <div class="flex items-center space-x-1 mt-1">
                                            @if($weightChange > 0)
                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-3 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                                                </svg>
                                                <span class="text-xs text-red-600 font-medium">+{{ number_format($weightChange, 1) }} kg</span>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-3 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/>
                                                </svg>
                                                <span class="text-xs text-green-600 font-medium">{{ number_format($weightChange, 1) }} kg</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Quick Stats -->
                            <div class="hidden sm:flex items-center space-x-3">
                                @if($hasMeasurements)
                                    <div class="flex items-center space-x-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        <span class="text-xs text-slate-600 dark:text-navy-300">Measurements</span>
                                    </div>
                                @endif
                                
                                @if($hasComposition)
                                    <div class="flex items-center space-x-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                        </svg>
                                        <span class="text-xs text-slate-600 dark:text-navy-300">Composition</span>
                                    </div>
                                @endif
                                
                                @if($hasImages)
                                    <div class="flex items-center space-x-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="text-xs text-slate-600 dark:text-navy-300">{{ $entry->progressImages->count() }} photos</span>
                                    </div>
                                @endif
                                
                                @if($entry->notes)
                                    <div class="flex items-center space-x-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <span class="text-xs text-slate-600 dark:text-navy-300">Notes</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            <!-- Time Ago -->
                            <div class="text-xs text-slate-500 dark:text-navy-300 text-right hidden sm:block">
                                {{ $entry->measurement_date->diffForHumans() }}
                            </div>
                            
                            <!-- Actions -->
                            <div class="flex items-center space-x-1">
                                <a href="{{ route('dietitian.progress.edit', ['patient' => $patient->id, 'progress' => $entry->id]) }}" 
                                   class="btn size-8 rounded-full p-0 hover:bg-info/20 text-info" title="Edit Entry">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                
                                <!-- Expand/Collapse Icon -->
                                <button class="btn size-8 rounded-full p-0 hover:bg-slate-200 dark:hover:bg-navy-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                         :class="{ 'rotate-180': openEntry === {{ $index }} }">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Expandable Content -->
                    <div x-show="openEntry === {{ $index }}" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 max-h-0"
                         x-transition:enter-end="opacity-100 max-h-screen"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 max-h-screen"
                         x-transition:leave-end="opacity-0 max-h-0"
                         class="border-t border-slate-200 dark:border-navy-500 overflow-hidden"
                         style="display: none;">
                        
                        <div class="p-4 bg-slate-50/50 dark:bg-navy-600/25">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <!-- Left Column -->
                                <div class="space-y-4">
                                    @if($hasMeasurements)
                                        <!-- Body Measurements -->
                                        <div>
                                            <h5 class="text-sm font-semibold text-slate-700 dark:text-navy-100 mb-3 flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                                Body Measurements
                                            </h5>
                                            <div class="grid grid-cols-2 gap-3 text-sm">
                                                @if($entry->chest)
                                                    <div class="flex justify-between p-2 rounded bg-white dark:bg-navy-700/50">
                                                        <span class="text-slate-600 dark:text-navy-300">Chest:</span>
                                                        <span class="font-medium">{{ $entry->chest }} cm</span>
                                                    </div>
                                                @endif
                                                @if($entry->waist)
                                                    <div class="flex justify-between p-2 rounded bg-white dark:bg-navy-700/50">
                                                        <span class="text-slate-600 dark:text-navy-300">Waist:</span>
                                                        <span class="font-medium">{{ $entry->waist }} cm</span>
                                                    </div>
                                                @endif
                                                @if($entry->hips)
                                                    <div class="flex justify-between p-2 rounded bg-white dark:bg-navy-700/50">
                                                        <span class="text-slate-600 dark:text-navy-300">Hips:</span>
                                                        <span class="font-medium">{{ $entry->hips }} cm</span>
                                                    </div>
                                                @endif
                                                @if($entry->left_arm)
                                                    <div class="flex justify-between p-2 rounded bg-white dark:bg-navy-700/50">
                                                        <span class="text-slate-600 dark:text-navy-300">Left Arm:</span>
                                                        <span class="font-medium">{{ $entry->left_arm }} cm</span>
                                                    </div>
                                                @endif
                                                @if($entry->right_arm)
                                                    <div class="flex justify-between p-2 rounded bg-white dark:bg-navy-700/50">
                                                        <span class="text-slate-600 dark:text-navy-300">Right Arm:</span>
                                                        <span class="font-medium">{{ $entry->right_arm }} cm</span>
                                                    </div>
                                                @endif
                                                @if($entry->left_thigh)
                                                    <div class="flex justify-between p-2 rounded bg-white dark:bg-navy-700/50">
                                                        <span class="text-slate-600 dark:text-navy-300">Left Thigh:</span>
                                                        <span class="font-medium">{{ $entry->left_thigh }} cm</span>
                                                    </div>
                                                @endif
                                                @if($entry->right_thigh)
                                                    <div class="flex justify-between p-2 rounded bg-white dark:bg-navy-700/50">
                                                        <span class="text-slate-600 dark:text-navy-300">Right Thigh:</span>
                                                        <span class="font-medium">{{ $entry->right_thigh }} cm</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                    
                                    @if($hasComposition)
                                        <!-- Body Composition -->
                                        <div>
                                            <h5 class="text-sm font-semibold text-slate-700 dark:text-navy-100 mb-3 flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                                </svg>
                                                Body Composition
                                            </h5>
                                            <div class="grid grid-cols-2 gap-3 text-sm">
                                                @if($entry->fat_mass)
                                                    <div class="flex justify-between p-2 rounded bg-white dark:bg-navy-700/50">
                                                        <span class="text-slate-600 dark:text-navy-300">Fat Mass:</span>
                                                        <span class="font-medium">{{ $entry->fat_mass }} kg</span>
                                                    </div>
                                                @endif
                                                @if($entry->muscle_mass)
                                                    <div class="flex justify-between p-2 rounded bg-white dark:bg-navy-700/50">
                                                        <span class="text-slate-600 dark:text-navy-300">Muscle Mass:</span>
                                                        <span class="font-medium">{{ $entry->muscle_mass }} kg</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Right Column -->
                                <div class="space-y-4">
                                    @if($hasImages)
                                        <!-- Progress Images -->
                                        <div>
                                            <h5 class="text-sm font-semibold text-slate-700 dark:text-navy-100 mb-3 flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                Progress Images ({{ $entry->progressImages->count() }})
                                            </h5>
                                            <div class="grid grid-cols-3 gap-2" x-data="{ lightbox: null }">
                                                @foreach($entry->progressImages as $imageIndex => $image)
                                                    <div class="relative group cursor-pointer" @click="lightbox = '{{ asset('storage/' . $image->image_path) }}'">
                                                        <img src="{{ asset('storage/' . $image->image_path) }}" 
                                                             alt="Progress Image {{ $imageIndex + 1 }}" 
                                                             class="w-full h-20 object-cover rounded border border-slate-200 dark:border-navy-600 hover:opacity-80 transition-opacity">
                                                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-200 rounded flex items-center justify-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                
                                                <!-- Lightbox Modal -->
                                                <div x-show="lightbox" 
                                                     x-transition:enter="transition ease-out duration-300"
                                                     x-transition:enter-start="opacity-0"
                                                     x-transition:enter-end="opacity-100"
                                                     @click="lightbox = null"
                                                     @keydown.escape="lightbox = null"
                                                     class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-4"
                                                     style="display: none;">
                                                    <div class="relative max-w-4xl max-h-full">
                                                        <img :src="lightbox" class="max-w-full max-h-full rounded-lg shadow-2xl">
                                                        <button @click="lightbox = null" 
                                                                class="absolute top-4 right-4 text-white hover:text-gray-300 transition-colors">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    @if($entry->notes)
                                        <!-- Notes -->
                                        <div>
                                            <h5 class="text-sm font-semibold text-slate-700 dark:text-navy-100 mb-3 flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                                Notes
                                            </h5>
                                            <div class="p-3 rounded bg-white dark:bg-navy-700/50 border border-slate-200 dark:border-navy-500">
                                                <p class="text-sm text-slate-700 dark:text-navy-200 leading-relaxed whitespace-pre-line">{{ $entry->notes }}</p>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <!-- Entry Actions -->
                                    <div class="pt-2 border-t border-slate-200 dark:border-navy-500">
                                        <div class="flex items-center justify-between">
                                            <div class="text-xs text-slate-500 dark:text-navy-300">
                                                Added {{ $entry->created_at->diffForHumans() }}
                                                @if($entry->created_at != $entry->updated_at)
                                                    • Updated {{ $entry->updated_at->diffForHumans() }}
                                                @endif
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <a href="{{ route('dietitian.progress.edit', ['patient' => $patient->id, 'progress' => $entry->id]) }}" 
                                                   class="btn rounded-lg bg-info/10 px-3 py-1 text-xs font-medium text-info hover:bg-info/20 transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                    Edit
                                                </a>
                                                <form method="POST" action="{{ route('dietitian.progress.destroy', ['patient' => $patient->id, 'progress' => $entry->id]) }}" 
                                                      onsubmit="return confirm('Are you sure you want to delete this progress entry? This action cannot be undone.');" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn rounded-lg bg-error/10 px-3 py-1 text-xs font-medium text-error hover:bg-error/20 transition-colors">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="card">
            <div class="flex flex-col items-center justify-center py-12">
                <div class="flex items-center justify-center size-20 rounded-full bg-slate-100 text-slate-400 dark:bg-navy-600 dark:text-navy-300 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <h4 class="text-lg font-medium text-slate-700 dark:text-navy-100 mb-2">No Progress Entries Yet</h4>
                <p class="text-slate-500 dark:text-navy-300 text-center mb-6 max-w-md">
                    Start tracking {{ $patient->user->name }}'s progress by adding their first weight measurement, body measurements, and progress photos.
                </p>
                <a href="{{ route('dietitian.progress.create', $patient->id) }}" 
                   class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add First Progress Entry
                </a>
            </div>
        </div>
    @endif
</div>

                    <!-- Enhanced Medical Info Tab -->
                    <div x-show="activeTab === 'medicalTab'" class="p-4 sm:p-5" style="display: none;">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="flex items-center justify-center size-10 rounded-full bg-red-100 text-red-600 dark:bg-red-900/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-slate-800 dark:text-navy-50">Medical History</h3>
                                <p class="text-sm text-slate-500 dark:text-navy-300">Complete medical background and health information</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div class="space-y-6">
                                <!-- Chronic Diseases -->
                                <div>
                                    <h4 class="text-base font-medium text-slate-700 dark:text-navy-100 mb-3 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                        </svg>
                                        Chronic Diseases
                                    </h4>
                                    <div class="rounded-lg border border-slate-200 bg-slate-50/50 p-4 dark:border-navy-500 dark:bg-navy-600/25">
                                        @if($patient->medical_conditions)
                                            <p class="text-sm leading-relaxed">{{ $patient->medical_conditions }}</p>
                                        @else
                                            <p class="text-slate-500 dark:text-navy-300 italic text-sm">No chronic diseases recorded</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Current Medications -->
                                <div>
                                    <h4 class="text-base font-medium text-slate-700 dark:text-navy-100 mb-3 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                        </svg>
                                        Current Medications
                                    </h4>
                                    <div class="rounded-lg border border-slate-200 bg-slate-50/50 p-4 dark:border-navy-500 dark:bg-navy-600/25">
                                        @if($patient->medications)
                                            <p class="text-sm leading-relaxed">{{ $patient->medications }}</p>
                                        @else
                                            <p class="text-slate-500 dark:text-navy-300 italic text-sm">No medications recorded</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Previous Surgeries -->
                                <div>
                                    <h4 class="text-base font-medium text-slate-700 dark:text-navy-100 mb-3 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                                        </svg>
                                        Previous Surgeries
                                    </h4>
                                    <div class="rounded-lg border border-slate-200 bg-slate-50/50 p-4 dark:border-navy-500 dark:bg-navy-600/25">
                                        @if($patient->surgeries)
                                            <p class="text-sm leading-relaxed">{{ $patient->surgeries }}</p>
                                        @else
                                            <p class="text-slate-500 dark:text-navy-300 italic text-sm">No surgeries recorded</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Food Allergies -->
                                <div>
                                    <h4 class="text-base font-medium text-slate-700 dark:text-navy-100 mb-3 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                        </svg>
                                        Food Allergies & Intolerances
                                    </h4>
                                    <div class="rounded-lg border border-slate-200 bg-slate-50/50 p-4 dark:border-navy-500 dark:bg-navy-600/25">
                                        @if($patient->allergies)
                                            <p class="text-sm leading-relaxed">{{ $patient->allergies }}</p>
                                        @else
                                            <p class="text-slate-500 dark:text-navy-300 italic text-sm">No allergies recorded</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-6">
                                <!-- Smoking Status -->
                                <div>
                                    <h4 class="text-base font-medium text-slate-700 dark:text-navy-100 mb-3 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                        </svg>
                                        Smoking Status
                                    </h4>
                                    <div class="rounded-lg border border-slate-200 bg-slate-50/50 p-4 dark:border-navy-500 dark:bg-navy-600/25">
                                        @if($patient->smoking_status)
                                            <p class="text-sm leading-relaxed">{{ $patient->smoking_status }}</p>
                                        @else
                                            <p class="text-slate-500 dark:text-navy-300 italic text-sm">No smoking information recorded</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- GI Symptoms -->
                                <div>
                                    <h4 class="text-base font-medium text-slate-700 dark:text-navy-100 mb-3 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                        </svg>
                                        Gastrointestinal Symptoms
                                    </h4>
                                    <div class="rounded-lg border border-slate-200 bg-slate-50/50 p-4 dark:border-navy-500 dark:bg-navy-600/25">
                                        @if($patient->gi_symptoms)
                                            <p class="text-sm leading-relaxed">{{ $patient->gi_symptoms }}</p>
                                        @else
                                            <p class="text-slate-500 dark:text-navy-300 italic text-sm">No GI symptoms recorded</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Recent Blood Tests -->
                                <div>
                                    <h4 class="text-base font-medium text-slate-700 dark:text-navy-100 mb-3 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        Recent Blood Tests
                                    </h4>
                                    <div class="rounded-lg border border-slate-200 bg-slate-50/50 p-4 dark:border-navy-500 dark:bg-navy-600/25">
                                        @if($patient->recent_blood_test)
                                            <p class="text-sm leading-relaxed">{{ $patient->recent_blood_test }}</p>
                                        @else
                                            <p class="text-slate-500 dark:text-navy-300 italic text-sm">No recent blood test results recorded</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Dietary Preferences -->
                                <div>
                                    <h4 class="text-base font-medium text-slate-700 dark:text-navy-100 mb-3 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                        </svg>
                                        Dietary Preferences
                                    </h4>
                                    <div class="rounded-lg border border-slate-200 bg-slate-50/50 p-4 dark:border-navy-500 dark:bg-navy-600/25">
                                        @if($patient->dietary_preferences)
                                            <p class="text-sm leading-relaxed">{{ $patient->dietary_preferences }}</p>
                                        @else
                                            <p class="text-slate-500 dark:text-navy-300 italic text-sm">No dietary preferences recorded</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- New Food History Tab -->
                    <div x-show="activeTab === 'foodHistoryTab'" class="p-4 sm:p-5" style="display: none;">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="flex items-center justify-center size-10 rounded-full bg-green-100 text-green-600 dark:bg-green-900/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 002 2h1a2 2 0 002-2v-6"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-slate-800 dark:text-navy-50">Food History & Lifestyle</h3>
                                <p class="text-sm text-slate-500 dark:text-navy-300">Dietary habits, lifestyle patterns, and nutrition background</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Left Column - Daily Habits -->
                            <div class="space-y-6">
                                <div class="bg-blue-50 dark:bg-navy-600/25 rounded-lg p-4 border border-blue-200 dark:border-navy-500">
                                    <h4 class="text-base font-semibold text-blue-800 dark:text-blue-300 mb-4 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Daily Habits
                                    </h4>
                                    
                                    <!-- Daily Routine -->
                                    <div class="mb-4">
                                        <h5 class="text-sm font-medium text-slate-700 dark:text-navy-100 mb-2">Daily Eating Routine</h5>
                                        <div class="rounded-lg border border-slate-200 bg-white/50 p-3 dark:border-navy-500 dark:bg-navy-700/25">
                                            @if($patient->daily_routine)
                                                <p class="text-sm leading-relaxed">{{ $patient->daily_routine }}</p>
                                            @else
                                                <p class="text-slate-500 dark:text-navy-300 italic text-sm">No daily routine recorded</p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Alcohol Intake -->
                                    <div class="mb-4">
                                        <h5 class="text-sm font-medium text-slate-700 dark:text-navy-100 mb-2">Alcohol Intake</h5>
                                        <div class="rounded-lg border border-slate-200 bg-white/50 p-3 dark:border-navy-500 dark:bg-navy-700/25">
                                            @if($patient->alcohol_intake)
                                                <p class="text-sm leading-relaxed">{{ $patient->alcohol_intake }}</p>
                                            @else
                                                <p class="text-slate-500 dark:text-navy-300 italic text-sm">No alcohol information recorded</p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Coffee Intake -->
                                    <div>
                                        <h5 class="text-sm font-medium text-slate-700 dark:text-navy-100 mb-2">Coffee Intake</h5>
                                        <div class="rounded-lg border border-slate-200 bg-white/50 p-3 dark:border-navy-500 dark:bg-navy-700/25">
                                            @if($patient->coffee_intake)
                                                <p class="text-sm leading-relaxed">{{ $patient->coffee_intake }}</p>
                                            @else
                                                <p class="text-slate-500 dark:text-navy-300 italic text-sm">No coffee information recorded</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Supplements -->
                                <div>
                                    <h4 class="text-base font-medium text-slate-700 dark:text-navy-100 mb-3 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                        </svg>
                                        Vitamins & Supplements
                                    </h4>
                                    <div class="rounded-lg border border-slate-200 bg-slate-50/50 p-4 dark:border-navy-500 dark:bg-navy-600/25">
                                        @if($patient->vitamin_intake)
                                            <p class="text-sm leading-relaxed">{{ $patient->vitamin_intake }}</p>
                                        @else
                                            <p class="text-slate-500 dark:text-navy-300 italic text-sm">No vitamins or supplements recorded</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Physical Activity -->
                                <div>
                                    <h4 class="text-base font-medium text-slate-700 dark:text-navy-100 mb-3 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                        </svg>
                                        Physical Activity Details
                                    </h4>
                                    <div class="rounded-lg border border-slate-200 bg-slate-50/50 p-4 dark:border-navy-500 dark:bg-navy-600/25">
                                        @if($patient->physical_activity_details)
                                            <p class="text-sm leading-relaxed">{{ $patient->physical_activity_details }}</p>
                                        @else
                                            <p class="text-slate-500 dark:text-navy-300 italic text-sm">No detailed physical activity information recorded</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column - History & Goals -->
                            <div class="space-y-6">
                                <!-- Previous Diets -->
                                <div>
                                    <h4 class="text-base font-medium text-slate-700 dark:text-navy-100 mb-3 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        Previous Diet Attempts
                                    </h4>
                                    <div class="rounded-lg border border-slate-200 bg-slate-50/50 p-4 dark:border-navy-500 dark:bg-navy-600/25">
                                        @if($patient->previous_diets)
                                            <p class="text-sm leading-relaxed">{{ $patient->previous_diets }}</p>
                                        @else
                                            <p class="text-slate-500 dark:text-navy-300 italic text-sm">No previous diet information recorded</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Weight History -->
                                <div>
                                    <h4 class="text-base font-medium text-slate-700 dark:text-navy-100 mb-3 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                        </svg>
                                        Weight History (Last 5 Years)
                                    </h4>
                                    <div class="rounded-lg border border-slate-200 bg-slate-50/50 p-4 dark:border-navy-500 dark:bg-navy-600/25">
                                        @if($patient->weight_history)
                                            <p class="text-sm leading-relaxed">{{ $patient->weight_history }}</p>
                                        @else
                                            <p class="text-slate-500 dark:text-navy-300 italic text-sm">No weight history recorded</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Goals & Motivation -->
                                <div class="bg-emerald-50 dark:bg-emerald-900/25 rounded-lg p-4 border border-emerald-200 dark:border-emerald-700/50">
                                    <h4 class="text-base font-semibold text-emerald-800 dark:text-emerald-300 mb-3 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                        </svg>
                                        Goals & Motivation
                                    </h4>
                                    <div class="rounded-lg border border-emerald-200 bg-white/50 p-3 dark:border-emerald-600/50 dark:bg-emerald-900/25">
                                        @if($patient->subscription_reason)
                                            <p class="text-sm leading-relaxed">{{ $patient->subscription_reason }}</p>
                                        @else
                                            <p class="text-slate-500 dark:text-navy-300 italic text-sm">No goals or motivation recorded</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Quick Stats Summary -->
                                @if($patient->height || $patient->initial_weight || $patient->goal_weight)
                                <div class="bg-slate-100 dark:bg-navy-600/50 rounded-lg p-4">
                                    <h4 class="text-base font-medium text-slate-700 dark:text-navy-100 mb-3 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                        </svg>
                                        Quick Physical Summary
                                    </h4>
                                    <div class="grid grid-cols-2 gap-3 text-sm">
                                        @if($patient->height)
                                        <div class="flex justify-between">
                                            <span class="text-slate-600 dark:text-navy-300">Height:</span>
                                            <span class="font-medium">{{ $patient->height }} cm</span>
                                        </div>
                                        @endif
                                        @if($patient->initial_weight)
                                        <div class="flex justify-between">
                                            <span class="text-slate-600 dark:text-navy-300">Initial:</span>
                                            <span class="font-medium">{{ $patient->initial_weight }} kg</span>
                                        </div>
                                        @endif
                                        @if($patient->goal_weight)
                                        <div class="flex justify-between">
                                            <span class="text-slate-600 dark:text-navy-300">Goal:</span>
                                            <span class="font-medium text-primary">{{ $patient->goal_weight }} kg</span>
                                        </div>
                                        @endif
                                        @if($patient->height && $patient->initial_weight && $patient->goal_weight)
                                        @php
                                            $weightDiff = $patient->initial_weight - $patient->goal_weight;
                                        @endphp
                                        <div class="flex justify-between col-span-2 pt-2 border-t border-slate-200 dark:border-navy-500">
                                            <span class="text-slate-600 dark:text-navy-300">Target </span>
                                            <span class="font-medium {{ $weightDiff > 0 ? 'text-success' : 'text-warning' }}">
                                                {{ abs($weightDiff) }} kg {{ $weightDiff > 0 ? 'loss' : 'gain' }}
                                            </span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Notes Tab -->
                    <div x-show="activeTab === 'notesTab'" class="p-4 sm:p-5" style="display: none;">
                        <div class="flex justify-between mb-5">
                            <h3 class="text-base font-medium text-slate-700 dark:text-navy-100">
                                Patient Notes
                            </h3>
                            <button class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Add Note
                            </button>
                        </div>
                        
                        <div class="rounded-lg border border-slate-300 p-4 dark:border-navy-450">
                            @if($patient->notes)
                                <p class="whitespace-pre-line">{{ $patient->notes }}</p>
                            @else
                                <div class="flex flex-col items-center justify-center py-8">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-16 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="mt-2 text-slate-500 dark:text-navy-300">No notes have been added yet</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div id="deleteModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-slate-900/60 backdrop-blur">
            <div class="card w-full max-w-lg p-4 sm:p-5">
                <div class="mt-4 text-center sm:mt-5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-16 mx-auto text-error" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <h3 class="mt-4 text-xl font-medium text-slate-700 dark:text-navy-100">
                        Delete Patient
                    </h3>
                    <p class="mt-2 text-slate-500 dark:text-navy-300">
                        Are you sure you want to delete this patient? All data associated with this patient will be permanently removed. This action cannot be undone.
                    </p>
                </div>
                <div class="flex justify-center space-x-3 pt-4">
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="hideDeleteModal()" class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                            Cancel
                        </button>
                        <button type="submit" class="btn min-w-[7rem] rounded-full bg-error font-medium text-white hover:bg-error-focus focus:bg-error-focus active:bg-error-focus/90">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>
    
    @slot('script')
    <script>
        // Delete modal functionality
        function confirmDelete(patientId) {
            document.getElementById('deleteForm').action = '{{ route("dietitian.patients.index") }}/' + patientId;
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteModal').classList.add('flex');
        }

        function hideDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.getElementById('deleteModal').classList.remove('flex');
        }

        // Close modal when clicking outside
        document.getElementById('deleteModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                hideDeleteModal();
            }
        });

        // Meal Plans Manager
        function mealPlansManager() {
            return {
                isLoading: false,

                async activatePlan(planId) {
                    if (this.isLoading) return;
                    
                    this.isLoading = true;
                    
                    try {
                        const response = await fetch(`/dietitian/meal-plans/${planId}/activate`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });

                        if (response.ok) {
                            this.showToast('Meal plan activated successfully!', 'success');
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        } else {
                            const errorData = await response.json();
                            throw new Error(errorData.error || 'Failed to activate meal plan');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        this.showToast('Error activating meal plan. Please try again.', 'error');
                    } finally {
                        this.isLoading = false;
                    }
                },

                async deletePlan(planId) {
                    if (this.isLoading) return;
                    
                    if (!confirm('Are you sure you want to delete this meal plan? This action cannot be undone.')) {
                        return;
                    }
                    
                    this.isLoading = true;
                    
                    try {
                        const response = await fetch(`/dietitian/meal-plans/${planId}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });

                        if (response.ok) {
                            this.showToast('Meal plan deleted successfully!', 'success');
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        } else {
                            const errorData = await response.json();
                            throw new Error(errorData.error || 'Failed to delete meal plan');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        this.showToast('Error deleting meal plan. Please try again.', 'error');
                    } finally {
                        this.isLoading = false;
                    }
                },

                showToast(message, type = 'success') {
                    // Remove existing toasts
                    const existingToasts = document.querySelectorAll('.toast-notification');
                    existingToasts.forEach(toast => toast.remove());

                    // Create new toast
                    const toast = document.createElement('div');
                    toast.className = `toast-notification fixed top-4 right-4 z-50 max-w-md rounded-lg px-4 py-3 shadow-lg transition-all duration-300 transform ${
                        type === 'success' 
                            ? 'bg-success border border-success text-white' 
                            : 'bg-error border border-error text-white'
                    }`;
                    
                    toast.innerHTML = `
                        <div class="flex items-center space-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                ${type === 'success' 
                                    ? '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>'
                                    : '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>'
                }
                            </svg>
                            <span class="font-medium">${message}</span>
                            <button onclick="this.parentElement.parentElement.remove()" class="ml-auto flex-shrink-0 hover:opacity-70">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    `;
                    
                    // Add to DOM
                    document.body.appendChild(toast);
                    
                    // Animate in
                    setTimeout(() => {
                        toast.style.transform = 'translateX(0)';
                        toast.style.opacity = '1';
                    }, 100);
                    
                    // Auto remove after 4 seconds
                    setTimeout(() => {
                        if (toast.parentNode) {
                            toast.style.transform = 'translateX(100%)';
                            toast.style.opacity = '0';
                            setTimeout(() => {
                                if (toast.parentNode) {
                                    toast.parentNode.removeChild(toast);
                                }
                            }, 300);
                        }
                    }, 4000);
                }
            };
        }



        //////

        // Weight Progress Chart - Simplified Debug Version
@if($patient->progressEntries && $patient->progressEntries->count() > 0)
document.addEventListener('DOMContentLoaded', function() {
    console.log('Chart script starting...');
    
    const chartElement = document.getElementById('weightChart');
    if (!chartElement) {
        console.error('Chart canvas element not found!');
        return;
    }
    
    if (typeof Chart === 'undefined') {
        console.error('Chart.js library not loaded!');
        return;
    }
    
    const ctx = chartElement.getContext('2d');
    console.log('Canvas context obtained');
    
    // Prepare chart data
    const progressData = @json($patient->progressEntries->sortBy('measurement_date')->values());
    console.log('Progress data:', progressData);
    
    if (!progressData || progressData.length === 0) {
        console.error('No progress data available');
        return;
    }
    
    const labels = progressData.map(entry => {
        const date = new Date(entry.measurement_date);
        return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
    });
    
    const weights = progressData.map(entry => parseFloat(entry.weight));
    console.log('Labels:', labels);
    console.log('Weights:', weights);
    
    try {
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Weight Progress',
                    data: weights,
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3,
                    pointBackgroundColor: '#3b82f6',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Weight (kg)'
                        },
                        beginAtZero: false
                    }
                }
            }
        });
        console.log('Chart created successfully!', chart);
    } catch (error) {
        console.error('Error creating chart:', error);
    }
});
@endif
    </script>
    @endslot
</x-app-layout>