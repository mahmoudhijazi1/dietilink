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
                <div class="card" x-data="progressEntryEditForm()">
                    <div class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                        <div class="flex items-center space-x-3">
                            <div class="flex items-center justify-center size-10 rounded-full bg-primary/10 text-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                                    Edit Progress Entry
                                </h2>
                                <p class="text-sm text-slate-500 dark:text-navy-300">
                                    Update {{ $patient->user->name }}'s progress measurements
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('dietitian.patients.show', $patient->id) }}"
                            class="btn rounded-full border border-slate-300 font-medium text-slate-700 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back to Patient
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

                        <form method="POST" action="{{ route('dietitian.progress.update', ['patient' => $patient->id, 'progress' => $progressEntry->id]) }}" 
                              enctype="multipart/form-data" 
                              @submit="isSubmitting = true" 
                              class="space-y-6">
                            @csrf
                            @method('PUT')
                            
                            <!-- Basic Information -->
                            <div class="space-y-6">
                                <div class="flex items-center space-x-3 mb-4">
                                    <div class="flex items-center justify-center size-8 rounded-full bg-blue-100 text-blue-600 dark:bg-blue-900/30">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-base font-semibold text-slate-800 dark:text-navy-50">Basic Measurements</h3>
                                        <p class="text-sm text-slate-500 dark:text-navy-300">Weight and measurement date</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                    <label class="block">
                                        <span class="font-medium text-slate-700 dark:text-navy-100">Weight (kg) *</span>
                                        <input
                                            class="form-input mt-2 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
                                            placeholder="Enter weight in kg" 
                                            type="number" 
                                            step="0.1" 
                                            min="0" 
                                            max="999.99" 
                                            name="weight" 
                                            value="{{ old('weight', $progressEntry->weight) }}" 
                                            required />
                                    </label>
                                    
                                    <label class="block">
                                        <span class="font-medium text-slate-700 dark:text-navy-100">Measurement Date *</span>
                                        <input
                                            class="form-input mt-2 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
                                            type="date" 
                                            name="measurement_date" 
                                            value="{{ old('measurement_date', $progressEntry->measurement_date->format('Y-m-d')) }}" 
                                            max="{{ date('Y-m-d') }}"
                                            required />
                                    </label>
                                </div>
                            </div>

                            <!-- Body Measurements -->
                            <div class="space-y-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex items-center justify-center size-8 rounded-full bg-green-100 text-green-600 dark:bg-green-900/30">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-base font-semibold text-slate-800 dark:text-navy-50">Body Measurements</h3>
                                            <p class="text-sm text-slate-500 dark:text-navy-300">All measurements in centimeters (optional)</p>
                                        </div>
                                    </div>
                                    <button type="button" 
                                            @click="showMeasurements = !showMeasurements" 
                                            class="btn rounded-lg bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-200 dark:bg-navy-600 dark:text-navy-100 dark:hover:bg-navy-500 transition-all duration-200">
                                        <span x-text="showMeasurements ? 'Hide Measurements' : 'Show Measurements'"></span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 ml-2 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            :class="{ 'rotate-180': showMeasurements }">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                </div>
                                
                                <div x-show="showMeasurements" 
                                     x-transition:enter="transition ease-out duration-200" 
                                     x-transition:enter-start="opacity-0 transform -translate-y-2" 
                                     x-transition:enter-end="opacity-100 transform translate-y-0" 
                                     class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                                    
                                    <!-- Upper Body -->
                                    <label class="block">
                                        <span class="font-medium text-slate-700 dark:text-navy-100">Chest (cm)</span>
                                        <input
                                            class="form-input mt-2 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
                                            placeholder="Chest measurement" 
                                            type="number" 
                                            step="0.1" 
                                            min="0" 
                                            max="999.99" 
                                            name="chest" 
                                            value="{{ old('chest', $progressEntry->chest) }}" />
                                    </label>
                                    
                                    <label class="block">
                                        <span class="font-medium text-slate-700 dark:text-navy-100">Left Arm (cm)</span>
                                        <input
                                            class="form-input mt-2 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
                                            placeholder="Left arm measurement" 
                                            type="number" 
                                            step="0.1" 
                                            min="0" 
                                            max="999.99" 
                                            name="left_arm" 
                                            value="{{ old('left_arm', $progressEntry->left_arm) }}" />
                                    </label>
                                    
                                    <label class="block">
                                        <span class="font-medium text-slate-700 dark:text-navy-100">Right Arm (cm)</span>
                                        <input
                                            class="form-input mt-2 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
                                            placeholder="Right arm measurement" 
                                            type="number" 
                                            step="0.1" 
                                            min="0" 
                                            max="999.99" 
                                            name="right_arm" 
                                            value="{{ old('right_arm', $progressEntry->right_arm) }}" />
                                    </label>
                                    
                                    <!-- Core -->
                                    <label class="block">
                                        <span class="font-medium text-slate-700 dark:text-navy-100">Waist (cm)</span>
                                        <input
                                            class="form-input mt-2 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
                                            placeholder="Waist measurement" 
                                            type="number" 
                                            step="0.1" 
                                            min="0" 
                                            max="999.99" 
                                            name="waist" 
                                            value="{{ old('waist', $progressEntry->waist) }}" />
                                    </label>
                                    
                                    <label class="block">
                                        <span class="font-medium text-slate-700 dark:text-navy-100">Hips (cm)</span>
                                        <input
                                            class="form-input mt-2 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
                                            placeholder="Hips measurement" 
                                            type="number" 
                                            step="0.1" 
                                            min="0" 
                                            max="999.99" 
                                            name="hips" 
                                            value="{{ old('hips', $progressEntry->hips) }}" />
                                    </label>
                                    
                                    <!-- Lower Body -->
                                    <label class="block">
                                        <span class="font-medium text-slate-700 dark:text-navy-100">Left Thigh (cm)</span>
                                        <input
                                            class="form-input mt-2 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
                                            placeholder="Left thigh measurement" 
                                            type="number" 
                                            step="0.1" 
                                            min="0" 
                                            max="999.99" 
                                            name="left_thigh" 
                                            value="{{ old('left_thigh', $progressEntry->left_thigh) }}" />
                                    </label>
                                    
                                    <label class="block">
                                        <span class="font-medium text-slate-700 dark:text-navy-100">Right Thigh (cm)</span>
                                        <input
                                            class="form-input mt-2 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
                                            placeholder="Right thigh measurement" 
                                            type="number" 
                                            step="0.1" 
                                            min="0" 
                                            max="999.99" 
                                            name="right_thigh" 
                                            value="{{ old('right_thigh', $progressEntry->right_thigh) }}" />
                                    </label>
                                </div>
                            </div>

                            <!-- Body Composition -->
                            <div class="space-y-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex items-center justify-center size-8 rounded-full bg-purple-100 text-purple-600 dark:bg-purple-900/30">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-base font-semibold text-slate-800 dark:text-navy-50">Body Composition</h3>
                                            <p class="text-sm text-slate-500 dark:text-navy-300">Fat and muscle mass in kilograms (optional)</p>
                                        </div>
                                    </div>
                                    <button type="button" 
                                            @click="showComposition = !showComposition" 
                                            class="btn rounded-lg bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-200 dark:bg-navy-600 dark:text-navy-100 dark:hover:bg-navy-500 transition-all duration-200">
                                        <span x-text="showComposition ? 'Hide Composition' : 'Show Composition'"></span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 ml-2 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            :class="{ 'rotate-180': showComposition }">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                </div>
                                
                                <div x-show="showComposition" 
                                     x-transition:enter="transition ease-out duration-200" 
                                     x-transition:enter-start="opacity-0 transform -translate-y-2" 
                                     x-transition:enter-end="opacity-100 transform translate-y-0" 
                                     class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                    
                                    <label class="block">
                                        <span class="font-medium text-slate-700 dark:text-navy-100">Fat Mass (kg)</span>
                                        <input
                                            class="form-input mt-2 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
                                            placeholder="Fat mass in kg" 
                                            type="number" 
                                            step="0.1" 
                                            min="0" 
                                            max="999.99" 
                                            name="fat_mass" 
                                            value="{{ old('fat_mass', $progressEntry->fat_mass) }}" />
                                    </label>
                                    
                                    <label class="block">
                                        <span class="font-medium text-slate-700 dark:text-navy-100">Muscle Mass (kg)</span>
                                        <input
                                            class="form-input mt-2 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
                                            placeholder="Muscle mass in kg" 
                                            type="number" 
                                            step="0.1" 
                                            min="0" 
                                            max="999.99" 
                                            name="muscle_mass" 
                                            value="{{ old('muscle_mass', $progressEntry->muscle_mass) }}" />
                                    </label>
                                </div>
                            </div>

                            <!-- Progress Images -->
                            <div class="space-y-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex items-center justify-center size-8 rounded-full bg-orange-100 text-orange-600 dark:bg-orange-900/30">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-base font-semibold text-slate-800 dark:text-navy-50">Progress Images</h3>
                                            <p class="text-sm text-slate-500 dark:text-navy-300">Manage progress photos (max 5MB each)</p>
                                        </div>
                                    </div>
                                    <button type="button" 
                                            @click="showImages = !showImages" 
                                            class="btn rounded-lg bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-200 dark:bg-navy-600 dark:text-navy-100 dark:hover:bg-navy-500 transition-all duration-200">
                                        <span x-text="showImages ? 'Hide Images' : 'Show Images'"></span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 ml-2 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            :class="{ 'rotate-180': showImages }">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                </div>
                                
                                <div x-show="showImages" 
                                     x-transition:enter="transition ease-out duration-200" 
                                     x-transition:enter-start="opacity-0 transform -translate-y-2" 
                                     x-transition:enter-end="opacity-100 transform translate-y-0">
                                    
                                    <!-- Existing Images -->
                                    @if($progressEntry->progressImages->count() > 0)
                                        <div class="mb-6">
                                            <h4 class="font-medium text-slate-700 dark:text-navy-100 mb-3">Current Images</h4>
                                            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                                                @foreach($progressEntry->progressImages as $image)
                                                    <div class="relative group">
                                                        <img src="{{ asset('storage/' . $image->image_path) }}" 
                                                             alt="Progress Image" 
                                                             class="w-full h-24 object-cover rounded-lg border border-slate-200 dark:border-navy-600">
                                                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-200 rounded-lg flex items-center justify-center">
                                                            <label class="flex items-center">
                                                                <input type="checkbox" 
                                                                       name="delete_images[]" 
                                                                       value="{{ $image->id }}"
                                                                       class="form-checkbox size-4 rounded border-white bg-white/20 checked:bg-error checked:border-error">
                                                                <span class="ml-2 text-white text-xs">Delete</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <p class="text-xs text-slate-500 dark:text-navy-300 mt-2">
                                                Hover over images and check the box to mark for deletion
                                            </p>
                                        </div>
                                    @endif
                                    
                                    <!-- Upload New Images -->
                                    <div class="border-2 border-dashed border-slate-300 rounded-lg p-6 dark:border-navy-600">
                                        <div class="text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-12 mx-auto text-slate-400 dark:text-navy-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                            </svg>
                                            <div class="mb-4">
                                                <label for="progress_images" class="cursor-pointer">
                                                    <span class="text-sm font-medium text-primary hover:text-primary-focus dark:text-accent dark:hover:text-accent-focus">
                                                        Add new progress images
                                                    </span>
                                                    <input id="progress_images" 
                                                           name="progress_images[]" 
                                                           type="file" 
                                                           class="sr-only" 
                                                           multiple 
                                                           accept="image/jpeg,image/png,image/jpg,image/webp"
                                                           @change="handleImagePreview">
                                                </label>
                                                <span class="text-slate-500 dark:text-navy-300"> or drag and drop</span>
                                            </div>
                                            <p class="text-xs text-slate-500 dark:text-navy-300">
                                                JPEG, PNG, JPG or WEBP up to 5MB each (max 5 images total)
                                            </p>
                                        </div>
                                        
                                        <!-- New Image Previews -->
                                        <div x-show="selectedImages.length > 0" class="mt-4 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4" style="display: none;">
                                            <template x-for="(image, index) in selectedImages" :key="index">
                                                <div class="relative group">
                                                    <img :src="image.url" :alt="'Preview ' + (index + 1)" class="w-full h-24 object-cover rounded-lg border border-slate-200 dark:border-navy-600">
                                                    <button type="button" 
                                                            @click="removeImage(index)"
                                                            class="absolute -top-2 -right-2 size-6 rounded-full bg-error text-white hover:bg-error-focus flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                        </svg>
                                                    </button>
                                                    <div class="absolute bottom-1 left-1 text-xs bg-black/70 text-white px-1 rounded">
                                                        <span x-text="(index + 1)"></span>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Notes -->
                            <div class="space-y-4">
                                <div class="flex items-center space-x-3">
                                    <div class="flex items-center justify-center size-8 rounded-full bg-gray-100 text-gray-600 dark:bg-gray-900/30">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-base font-semibold text-slate-800 dark:text-navy-50">Notes</h3>
                                        <p class="text-sm text-slate-500 dark:text-navy-300">Additional observations or comments</p>
                                    </div>
                                </div>

                                <label class="block">
                                    <span class="font-medium text-slate-700 dark:text-navy-100">Progress Notes</span>
                                    <textarea
                                        class="form-textarea mt-2 w-full resize-none rounded-lg border border-slate-300 bg-transparent p-3 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
                                        rows="4" 
                                        name="notes" 
                                        placeholder="Add any notes about this progress entry (diet changes, exercise routine, mood, energy levels, etc.)">{{ old('notes', $progressEntry->notes) }}</textarea>
                                </label>
                            </div>
                            
                            <!-- Form Actions -->
                            <div class="flex justify-end space-x-3 pt-6 border-t border-slate-200 dark:border-navy-500">
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
                                        Update Progress Entry
                                    </span>
                                    <span x-show="isSubmitting" class="flex items-center" style="display: none;">
                                        <svg class="animate-spin size-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Updating...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Patient Info Sidebar -->
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
                        <!-- Patient Stats -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-center p-3 rounded-lg bg-slate-50 dark:bg-navy-600/50">
                                <div class="text-lg font-semibold text-slate-800 dark:text-navy-50">
                                    {{ $patient->initial_weight ?? '--' }}
                                </div>
                                <div class="text-xs text-slate-500 dark:text-navy-300">Initial Weight (kg)</div>
                            </div>
                            <div class="text-center p-3 rounded-lg bg-slate-50 dark:bg-navy-600/50">
                                <div class="text-lg font-semibold text-slate-800 dark:text-navy-50">
                                    {{ $patient->goal_weight ?? '--' }}
                                </div>
                                <div class="text-xs text-slate-500 dark:text-navy-300">Goal Weight (kg)</div>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <div class="font-medium text-slate-600 dark:text-navy-100">Height</div>
                                <div>{{ $patient->height ?? 'Not recorded' }} {{ $patient->height ? 'cm' : '' }}</div>
                            </div>
                            @if($patient->height && $patient->initial_weight)
                            @php
                                $heightInMeters = $patient->height / 100;
                                $bmi = round($patient->initial_weight / ($heightInMeters * $heightInMeters), 1);
                            @endphp
                            <div class="flex justify-between">
                                <div class="font-medium text-slate-600 dark:text-navy-100">Initial BMI</div>
                                <div class="font-medium">{{ $bmi }}</div>
                            </div>
                            @endif
                        </div>

                        <div class="my-4 h-px bg-slate-200 dark:bg-navy-500"></div>

                        <!-- Current Entry Info -->
                        <div>
                            <h4 class="font-medium text-slate-600 dark:text-navy-100 mb-3">Current Entry</h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <div class="text-slate-500 dark:text-navy-300">Date:</div>
                                    <div>{{ $progressEntry->measurement_date->format('M d, Y') }}</div>
                                </div>
                                <div class="flex justify-between">
                                    <div class="text-slate-500 dark:text-navy-300">Weight:</div>
                                    <div class="font-medium">{{ $progressEntry->weight }} kg</div>
                                </div>
                                @if($progressEntry->chest || $progressEntry->waist || $progressEntry->hips)
                                    <div class="pt-2 border-t border-slate-200 dark:border-navy-500">
                                        <div class="text-xs text-slate-400 dark:text-navy-400 mb-1">Measurements:</div>
                                        @if($progressEntry->chest)
                                            <div class="flex justify-between text-xs">
                                                <span>Chest:</span><span>{{ $progressEntry->chest }} cm</span>
                                            </div>
                                        @endif
                                        @if($progressEntry->waist)
                                            <div class="flex justify-between text-xs">
                                                <span>Waist:</span><span>{{ $progressEntry->waist }} cm</span>
                                            </div>
                                        @endif
                                        @if($progressEntry->hips)
                                            <div class="flex justify-between text-xs">
                                                <span>Hips:</span><span>{{ $progressEntry->hips }} cm</span>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                                @if($progressEntry->progressImages->count() > 0)
                                    <div class="pt-2 border-t border-slate-200 dark:border-navy-500">
                                        <div class="text-xs text-slate-400 dark:text-navy-400 mb-1">
                                            {{ $progressEntry->progressImages->count() }} progress image{{ $progressEntry->progressImages->count() > 1 ? 's' : '' }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="my-4 h-px bg-slate-200 dark:bg-navy-500"></div>

                        <!-- Delete Progress Entry -->
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

    <script>
        function progressEntryEditForm() {
            return {
                // Form state
                isSubmitting: false,
                
                // Section toggles - Initialize based on existing data
                showMeasurements: {{ ($progressEntry->chest || $progressEntry->left_arm || $progressEntry->right_arm || $progressEntry->waist || $progressEntry->hips || $progressEntry->left_thigh || $progressEntry->right_thigh) ? 'true' : 'false' }},
                showComposition: {{ ($progressEntry->fat_mass || $progressEntry->muscle_mass) ? 'true' : 'false' }},
                showImages: {{ $progressEntry->progressImages->count() > 0 ? 'true' : 'false' }},
                
                // Image handling
                selectedImages: [],
                
                // Handle image file selection and preview
                handleImagePreview(event) {
                    const files = Array.from(event.target.files);
                    
                    // Limit to 5 images
                    if (files.length > 5) {
                        alert('You can only upload a maximum of 5 images.');
                        event.target.value = '';
                        return;
                    }
                    
                    // Clear previous selections
                    this.selectedImages = [];
                    
                    files.forEach((file, index) => {
                        // Validate file type
                        if (!file.type.match(/^image\/(jpeg|png|jpg|webp)$/)) {
                            alert(`File "${file.name}" is not a supported image format.`);
                            return;
                        }
                        
                        // Validate file size (5MB = 5 * 1024 * 1024 bytes)
                        if (file.size > 5 * 1024 * 1024) {
                            alert(`File "${file.name}" is too large. Maximum size is 5MB.`);
                            return;
                        }
                        
                        // Create preview
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.selectedImages.push({
                                file: file,
                                url: e.target.result,
                                name: file.name
                            });
                        };
                        reader.readAsDataURL(file);
                    });
                },
                
                // Remove image from selection
                removeImage(index) {
                    this.selectedImages.splice(index, 1);
                    
                    // Update the file input
                    const fileInput = document.getElementById('progress_images');
                    const dt = new DataTransfer();
                    
                    this.selectedImages.forEach(img => {
                        dt.items.add(img.file);
                    });
                    
                    fileInput.files = dt.files;
                }
            }
        }
    </script>
</x-app-layout>