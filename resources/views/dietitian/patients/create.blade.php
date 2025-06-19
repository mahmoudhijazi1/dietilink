<x-app-layout title="Create Patient" is-header-blur="true">
    <!-- Main Content Wrapper -->
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="flex items-center space-x-4 py-5 lg:py-6">
            <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
                Create New Patient
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
                <li>Create Patient</li>
            </ul>
        </div>

        <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
            <div class="col-span-12">
                <div class="card" x-data="patientCreateForm()">
                    <div
                        class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                        <div class="flex items-center space-x-3">
                            <div
                                class="flex items-center justify-center size-10 rounded-full bg-primary/10 text-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                                    Create Patient Account
                                </h2>
                                <p class="text-sm text-slate-500 dark:text-navy-300">
                                    Create a new patient account with login credentials
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('dietitian.patients.index') }}"
                            class="btn rounded-full border border-slate-300 font-medium text-slate-700 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to Patients
                        </a>
                    </div>

                    <div class="p-4 sm:p-5">
                        @if($errors->any())
                            <div class="alert flex rounded-lg border border-error px-4 py-4 text-error sm:px-5 mb-5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 mr-3 flex-shrink-0"
                                    viewBox="0 0 20 20" fill="currentColor">
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

                        <form method="POST" action="{{ route('dietitian.patients.store') }}" @submit="handleSubmit"
                            class="space-y-6">
                            @csrf

                            <!-- Account Credentials Section -->
                            <div class="space-y-6">
                                <div class="flex items-center space-x-3 mb-6">
                                    <div
                                        class="flex items-center justify-center size-8 rounded-full bg-blue-100 text-blue-600 dark:bg-blue-900/30">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-base font-semibold text-slate-800 dark:text-navy-50">Account
                                            Credentials</h3>
                                        <p class="text-sm text-slate-500 dark:text-navy-300">Login information for the
                                            patient</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                    <!-- Username with Real-time Validation -->
                                    <label class="block">
                                        <span class="font-medium text-slate-700 dark:text-navy-100">Username *</span>
                                        <span class="text-xs text-slate-500 block mt-1">This will be used for
                                            login</span>
                                        <div class="relative mt-2">
                                            <input
                                                class="form-input w-full rounded-lg border bg-transparent px-3 py-2.5 pr-10 placeholder:text-slate-400/70 hover:border-slate-400 focus:ring-2 focus:ring-primary/20 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
                                                :class="{
                                                    'border-slate-300 dark:border-navy-450 focus:border-primary': usernameStatus === null,
                                                    'border-success focus:border-success': usernameStatus === true,
                                                    'border-error focus:border-error': usernameStatus === false
                                                }" placeholder="Enter unique username" type="text" name="username"
                                                x-model="username" @input="checkUsername" required autocomplete="off" />

                                            <!-- Status Icon -->
                                            <div class="absolute right-3 top-1/2 -translate-y-1/2">
                                                <!-- Loading Spinner -->
                                                <svg x-show="isCheckingUsername"
                                                    class="animate-spin size-5 text-slate-400"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                                        stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor"
                                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                    </path>
                                                </svg>

                                                <!-- Success Icon -->
                                                <svg x-show="!isCheckingUsername && usernameStatus === true"
                                                    class="size-5 text-success" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>

                                                <!-- Error Icon -->
                                                <svg x-show="!isCheckingUsername && usernameStatus === false"
                                                    class="size-5 text-error" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                        </div>

                                        <!-- Status Message -->
                                        <div x-show="usernameMessage" class="mt-2 text-sm" :class="{
                                                'text-success': usernameStatus === true,
                                                'text-error': usernameStatus === false
                                            }">
                                            <span x-text="usernameMessage"></span>
                                        </div>
                                    </label>

                                    <!-- Password -->
                                    <label class="block">
                                        <span class="font-medium text-slate-700 dark:text-navy-100">Password *</span>
                                        <span class="text-xs text-slate-500 block mt-1">Minimum 8 characters</span>
                                        <div class="relative mt-2">
                                            <input
                                                class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2.5 pr-10 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
                                                placeholder="Enter secure password"
                                                :type="showPassword ? 'text' : 'password'" name="password" required
                                                minlength="8" autocomplete="new-password" />
                                            <button type="button" @click="showPassword = !showPassword"
                                                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:text-navy-300 dark:hover:text-navy-100">
                                                <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg"
                                                    class="size-5" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg"
                                                    class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    style="display: none;">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L12 12m-3.122-3.122l4.242 4.242M21 3l-6.878 6.878" />
                                                </svg>
                                            </button>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Personal Information Section -->
                            <div class="space-y-6">
                                <div class="flex items-center space-x-3 mb-6">
                                    <div
                                        class="flex items-center justify-center size-8 rounded-full bg-green-100 text-green-600 dark:bg-green-900/30">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-base font-semibold text-slate-800 dark:text-navy-50">Personal
                                            Information</h3>
                                        <p class="text-sm text-slate-500 dark:text-navy-300">Basic patient details</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                    <!-- Full Name -->
                                    <label class="block sm:col-span-2">
                                        <span class="font-medium text-slate-700 dark:text-navy-100">Full Name *</span>
                                        <input
                                            class="form-input mt-2 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
                                            placeholder="Enter patient's full name" type="text" name="name"
                                            value="{{ old('name') }}" required />
                                    </label>

                                    <!-- Phone Number -->
                                    <label class="block">
                                        <span class="font-medium text-slate-700 dark:text-navy-100">Phone Number</span>
                                        <input
                                            class="form-input mt-2 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
                                            placeholder="Enter phone number" type="tel" name="phone"
                                            value="{{ old('phone') }}" />
                                    </label>

                                    <!-- Gender -->
                                    <label class="block">
                                        <span class="font-medium text-slate-700 dark:text-navy-100">Gender</span>
                                        <select
                                            class="form-select mt-2 w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
                                            name="gender">
                                            <option value="">Select Gender</option>
                                            <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Male
                                            </option>
                                            <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>
                                                Female</option>
                                            <option value="other" {{ old('gender') === 'other' ? 'selected' : '' }}>Other
                                            </option>
                                        </select>
                                    </label>

                                    <!-- Date of Birth -->
                                    <label class="block">
                                        <span class="font-medium text-slate-700 dark:text-navy-100">Date of Birth</span>
                                        <input
                                            class="form-input mt-2 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
                                            type="date" name="date_of_birth" value="{{ old('date_of_birth') }}"
                                            max="{{ date('Y-m-d') }}" />
                                    </label>

                                    <!-- Occupation -->
                                    <label class="block">
                                        <span class="font-medium text-slate-700 dark:text-navy-100">Occupation</span>
                                        <input
                                            class="form-input mt-2 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent transition-all duration-200"
                                            placeholder="Enter occupation" type="text" name="occupation"
                                            value="{{ old('occupation') }}" />
                                    </label>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="flex justify-end space-x-3 pt-6 border-t border-slate-200 dark:border-navy-500">
                                <a href="{{ route('dietitian.patients.index') }}"
                                    class="btn rounded-lg border border-slate-300 px-6 py-2.5 font-medium text-slate-700 hover:bg-slate-50 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-600 transition-all duration-200">
                                    Cancel
                                </a>
                                <button type="submit" :disabled="isSubmitting || usernameStatus === false"
                                    class="btn rounded-lg bg-primary px-6 py-2.5 font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200">
                                    <span x-show="!isSubmitting" class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                        </svg>
                                        Create Patient
                                    </span>
                                    <span x-show="isSubmitting" class="flex items-center" style="display: none;">
                                        <svg class="animate-spin size-4 mr-2" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
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

    <script>
        function patientCreateForm() {
            return {
                // Form state
                showPassword: false,
                isSubmitting: false,

                // Username validation
                username: '{{ old("username") }}',
                usernameStatus: null, // null, true, false
                usernameMessage: '',
                isCheckingUsername: false,
                checkTimeout: null,

                // Check username availability with debouncing
                checkUsername() {
                    // Clear previous timeout
                    if (this.checkTimeout) {
                        clearTimeout(this.checkTimeout);
                    }

                    // Reset status if username is too short
                    if (this.username.length < 3) {
                        this.usernameStatus = null;
                        this.usernameMessage = '';
                        this.isCheckingUsername = false;
                        return;
                    }

                    // Show loading state
                    this.isCheckingUsername = true;
                    this.usernameStatus = null;
                    this.usernameMessage = '';

                    // Debounce the API call
                    this.checkTimeout = setTimeout(() => {
                        this.performUsernameCheck();
                    }, 500); // 500ms delay
                },

                // Perform the actual API call
                async performUsernameCheck() {
                    try {
                        const response = await fetch(`{{ route('api.check-username') }}?username=${encodeURIComponent(this.username)}`, {
                            method: 'GET',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'
                            }
                        });

                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }

                        const data = await response.json();

                        // Update status
                        this.usernameStatus = data.available;
                        this.usernameMessage = data.message;
                        this.isCheckingUsername = false;

                    } catch (error) {
                        console.error('Username check failed:', error);
                        this.usernameStatus = null;
                        this.usernameMessage = 'Unable to check username availability';
                        this.isCheckingUsername = false;
                    }
                },

                // Handle form submission
                handleSubmit(event) {
                    // Prevent submission if username is not available
                    if (this.usernameStatus === false) {
                        event.preventDefault();
                        alert('Please choose a different username.');
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
</x-app-layout>