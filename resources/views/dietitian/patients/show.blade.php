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
            <!-- Patient Info Card -->
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
                            <p class="text-xs+">
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
                    <div class="mt-6 space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-slate-400 dark:text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span class="font-medium">Email</span>
                            </div>
                            <span>{{ $patient->user->email }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-slate-400 dark:text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <span class="font-medium">Phone</span>
                            </div>
                            <span>{{ $patient->phone ?? 'Not provided' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-slate-400 dark:text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span class="font-medium">Gender</span>
                            </div>
                            <span>{{ $patient->gender ? ucfirst($patient->gender) : 'Not specified' }}</span>
                        </div>
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
                        
                        <!-- Weight & Height Information -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-slate-400 dark:text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                                </svg>
                                <span class="font-medium">Height</span>
                            </div>
                            <span>{{ $patient->height ?? 'Not recorded' }} {{ $patient->height ? 'cm' : '' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-slate-400 dark:text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="font-medium">Initial Weight</span>
                            </div>
                            <span>{{ $patient->initial_weight ?? 'Not recorded' }} {{ $patient->initial_weight ? 'kg' : '' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-slate-400 dark:text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                <span class="font-medium">Goal Weight</span>
                            </div>
                            <span>{{ $patient->goal_weight ?? 'Not set' }} {{ $patient->goal_weight ? 'kg' : '' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-slate-400 dark:text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                </svg>
                                <span class="font-medium">Activity Level</span>
                            </div>
                            <span>{{ $patient->activity_level ?? 'Not specified' }}</span>
                        </div>
                    </div>
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

            <!-- Tabs Section -->
            <div class="col-span-12 lg:col-span-8">
                <div class="card" x-data="{activeTab:'mealPlansTab'}">
                    <div class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                        <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                            Patient Information
                        </h2>
                        <div class="flex justify-center space-x-2">
                            <button @click="activeTab = 'mealPlansTab'" class="btn min-w-[7rem] rounded-full" :class="activeTab === 'mealPlansTab' ? 'bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90' : 'border border-slate-300 font-medium text-slate-700 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90'">
                                Meal Plans
                            </button>
                            <button @click="activeTab = 'progressTab'" class="btn min-w-[7rem] rounded-full" :class="activeTab === 'progressTab' ? 'bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90' : 'border border-slate-300 font-medium text-slate-700 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90'">
                                Progress
                            </button>
                            <button @click="activeTab = 'medicalTab'" class="btn min-w-[7rem] rounded-full" :class="activeTab === 'medicalTab' ? 'bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90' : 'border border-slate-300 font-medium text-slate-700 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90'">
                                Medical Info
                            </button>
                            <button @click="activeTab = 'notesTab'" class="btn min-w-[7rem] rounded-full" :class="activeTab === 'notesTab' ? 'bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90' : 'border border-slate-300 font-medium text-slate-700 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90'">
                                Notes
                            </button>
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
                                Weight Progress
                            </h3>
                            <a href="{{ route('dietitian.progress.create', $patient->id) }}" class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Add Progress Entry
                            </a>
                        </div>

                        <!-- Progress Entries Table -->
                        <div class="mt-5">
                            <h3 class="text-base font-medium text-slate-700 dark:text-navy-100 mb-3">
                                Progress History
                            </h3>
                            
                            @if(isset($patient->progressEntries) && count($patient->progressEntries) > 0)
                                <div class="min-w-full overflow-x-auto">
                                    <table class="w-full text-left">
                                        <thead>
                                            <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                                                    Date
                                                </th>
                                                <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                                                    Weight
                                                </th>
                                                <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                                                    Change
                                                </th>
                                                <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                                                    Measurements
                                                </th>
                                                <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                                                    Notes
                                                </th>
                                                <th class="whitespace-nowrap px-3 py-3 font-semibold text-right text-slate-800 dark:text-navy-100">
                                                    Actions
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($patient->progressEntries as $entry)
                                            <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                <td class="whitespace-nowrap px-3 py-3">
                                                    {{ $entry->measurement_date->format('M d, Y') }}
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-3">
                                                    {{ $entry->weight }} kg
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-3">
                                                    @php
                                                        $previousEntry = $patient->progressEntries->where('measurement_date', '<', $entry->measurement_date)->sortByDesc('measurement_date')->first();
                                                        $weightChange = $previousEntry ? $entry->weight - $previousEntry->weight : 0;
                                                    @endphp
                                                    
                                                    @if($weightChange > 0)
                                                        <span class="text-error">+{{ number_format($weightChange, 1) }} kg</span>
                                                    @elseif($weightChange < 0)
                                                        <span class="text-success">{{ number_format($weightChange, 1) }} kg</span>
                                                    @else
                                                        <span class="text-slate-400 dark:text-navy-300">No change</span>
                                                    @endif
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-3">
                                                    @if(!empty($entry->measurements))
                                                        <div x-data="{ showMeasurements: false }" class="cursor-pointer" @click="showMeasurements = !showMeasurements">
                                                            <span class="text-primary hover:text-primary-focus dark:text-accent-light dark:hover:text-accent">
                                                                <span x-show="!showMeasurements">View</span>
                                                                <span x-show="showMeasurements" style="display: none;">Hide</span>
                                                            </span>
                                                            <div x-show="showMeasurements" class="absolute z-50 mt-2 rounded-lg border border-slate-150 bg-white p-4 shadow-xl dark:border-navy-600 dark:bg-navy-700" style="display: none;">
                                                                <div class="space-y-1.5">
                                                                    @foreach($entry->measurements as $key => $value)
                                                                        <div class="flex justify-between">
                                                                            <span class="font-medium">{{ ucfirst($key) }}:</span>
                                                                            <span>{{ $value }} {{ $key === 'body_fat' ? '%' : 'cm' }}</span>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <span class="text-slate-400 dark:text-navy-300">None</span>
                                                    @endif
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-3">
                                                    <p class="line-clamp-1 w-48">{{ $entry->notes ?? 'No notes' }}</p>
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-3 text-right">
                                                    <div class="flex justify-end space-x-2">
                                                        <a href="{{ route('dietitian.progress.edit', ['patient' => $patient->id, 'progress' => $entry->id]) }}" class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                            </svg>
                                                        </a>
                                                        <form method="POST" action="{{ route('dietitian.progress.destroy', ['patient' => $patient->id, 'progress' => $entry->id]) }}" 
                                                            onsubmit="return confirm('Are you sure you want to delete this progress entry?');" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="flex flex-col items-center justify-center py-8">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-16 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                    <p class="mt-2 text-slate-500 dark:text-navy-300">No progress entries yet</p>
                                    <a href="{{ route('dietitian.progress.create', $patient->id) }}" class="btn mt-4 bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                        Add First Progress Entry
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Medical Info Tab -->
                    <div x-show="activeTab === 'medicalTab'" class="p-4 sm:p-5" style="display: none;">
                        <div class="space-y-5">
                            <div>
                                <h3 class="text-base font-medium text-slate-700 dark:text-navy-100">
                                    Medical Conditions
                                </h3>
                                <div class="mt-2 rounded-lg border border-slate-300 p-3 dark:border-navy-450">
                                    @if($patient->medical_conditions)
                                        <p>{{ $patient->medical_conditions }}</p>
                                    @else
                                        <p class="text-slate-500 dark:text-navy-300 italic">No medical conditions recorded</p>
                                    @endif
                                </div>
                            </div>
                            
                            <div>
                                <h3 class="text-base font-medium text-slate-700 dark:text-navy-100">
                                    Allergies
                                </h3>
                                <div class="mt-2 rounded-lg border border-slate-300 p-3 dark:border-navy-450">
                                    @if($patient->allergies)
                                        <p>{{ $patient->allergies }}</p>
                                    @else
                                        <p class="text-slate-500 dark:text-navy-300 italic">No allergies recorded</p>
                                    @endif
                                </div>
                            </div>
                            
                            <div>
                                <h3 class="text-base font-medium text-slate-700 dark:text-navy-100">
                                    Dietary Preferences
                                </h3>
                                <div class="mt-2 rounded-lg border border-slate-300 p-3 dark:border-navy-450">
                                    @if($patient->dietary_preferences)
                                        <p>{{ $patient->dietary_preferences }}</p>
                                    @else
                                        <p class="text-slate-500 dark:text-navy-300 italic">No dietary preferences recorded</p>
                                    @endif
                                </div>
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
    </script>
    @endslot
</x-app-layout>