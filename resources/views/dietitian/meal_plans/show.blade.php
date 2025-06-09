<x-app-layout title="View Meal Plan" is-header-blur="true">
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <!-- Breadcrumb -->
        <div class="flex items-center space-x-4 py-5 lg:py-6">
            <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">View Meal Plan</h2>
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
                    <a href="{{ route('dietitian.meal-plans.index') }}"
                        class="text-primary hover:text-primary-focus dark:text-accent-light dark:hover:text-accent">
                        Meal Plans
                    </a>
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </li>
                <li>{{ $mealPlan->name }}</li>
            </ul>
        </div>

        <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
            <!-- Main Content -->
            <div class="col-span-12 lg:col-span-8">
                <!-- Header Card -->
                <div class="card mb-6">
                    <div class="flex items-center justify-between border-b border-slate-200 px-4 py-4 dark:border-navy-500 sm:px-5">
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center justify-center size-12 rounded-full bg-primary/10 text-primary dark:bg-accent/10 dark:text-accent">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-xl font-semibold text-slate-800 dark:text-navy-50">{{ $mealPlan->name }}</h1>
                                <p class="text-sm text-slate-500 dark:text-navy-300">
                                    Created {{ $mealPlan->created_at->format('M d, Y') }} • 
                                    Updated {{ $mealPlan->updated_at->format('M d, Y') }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('dietitian.meal-plans.edit', $mealPlan->id) }}"
                                class="btn rounded-full bg-primary font-medium text-white hover:bg-primary-focus dark:bg-accent dark:hover:bg-accent-focus">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit Plan
                            </a>
                            <a href="{{ route('dietitian.meal-plans.index') }}"
                                class="btn rounded-full border border-slate-300 font-medium text-slate-700 hover:bg-slate-150 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-500">
                                Back to List
                            </a>
                        </div>
                    </div>

                    <!-- Basic Information -->
                    <div class="p-4 sm:p-5">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div class="flex items-center space-x-3">
                                <div class="flex items-center justify-center size-10 rounded-lg bg-info/10 text-info">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-slate-600 dark:text-navy-100">Patient</p>
                                    <p class="text-slate-800 dark:text-navy-50">{{ $mealPlan->patient->user->name }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="flex items-center justify-center size-10 rounded-lg bg-success/10 text-success">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-slate-600 dark:text-navy-100">Total Meals</p>
                                    <p class="text-slate-800 dark:text-navy-50">{{ $mealPlan->meals->count() }} meals configured</p>
                                </div>
                            </div>
                        </div>

                        @if($mealPlan->notes)
                        <div class="mt-4 p-4 rounded-lg bg-slate-50 dark:bg-navy-600">
                            <h3 class="text-sm font-medium text-slate-600 dark:text-navy-100 mb-2">Plan Notes</h3>
                            <p class="text-slate-700 dark:text-navy-200">{{ $mealPlan->notes }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Meals by Category -->
                @php
                    $mealsByType = $mealPlan->meals->groupBy('type');
                    $mealTypeOrder = ['breakfast', 'lunch', 'dinner', 'snack_1', 'snack_2'];
                    $mealTypeNames = [
                        'breakfast' => 'Breakfast',
                        'lunch' => 'Lunch', 
                        'dinner' => 'Dinner',
                        'snack_1' => 'Snack 1',
                        'snack_2' => 'Snack 2'
                    ];
                    $mealTypeIcons = [
                        'breakfast' => 'M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4',
                        'lunch' => 'M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7',
                        'dinner' => 'M19 7h-.3l-1.6 3.2c-.1.2-.3.3-.5.3h-1.2c-.2 0-.4-.1-.5-.3L13.3 7H13c-3.3 0-6 2.7-6 6v4c0 .6.4 1 1 1h10c.6 0 1-.4 1-1v-4c0-3.3-2.7-6-6-6z',
                        'snack_1' => 'M8 16l2.879-7.197a1 1 0 01.242-.391L12 8l.879.412a1 1 0 01.242.391L16 16H8zM8 16h8m-8 0l-2-6m10 6l2-6',
                        'snack_2' => 'M8 16l2.879-7.197a1 1 0 01.242-.391L12 8l.879.412a1 1 0 01.242.391L16 16H8zM8 16h8m-8 0l-2-6m10 6l2-6'
                    ];
                @endphp

                <div class="space-y-6">
                    @foreach($mealTypeOrder as $index => $type)
                        @if($mealsByType->has($type))
                            <div class="card overflow-hidden">
                                <!-- Meal Type Header -->
                                <div class="flex items-center justify-between bg-gradient-to-r from-primary/5 to-primary/10 dark:from-accent/5 dark:to-accent/10 px-4 py-4 border-b border-slate-200 dark:border-navy-500">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex items-center justify-center size-10 rounded-full bg-primary text-white dark:bg-accent text-sm font-bold">
                                            {{ $index + 1 }}
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-primary dark:text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $mealTypeIcons[$type] ?? 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2' }}"/>
                                            </svg>
                                            <h2 class="text-xl font-semibold text-slate-800 dark:text-navy-50">{{ $mealTypeNames[$type] }}</h2>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="inline-flex items-center justify-center rounded-full bg-primary/10 px-3 py-1 text-xs font-medium text-primary dark:bg-accent/10 dark:text-accent">
                                            {{ $mealsByType[$type]->count() }} {{ Str::plural('option', $mealsByType[$type]->count()) }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Meal Options -->
                                <div class="p-4 space-y-4">
                                    @foreach($mealsByType[$type] as $mealIndex => $meal)
                                        <div class="rounded-lg border border-slate-200 dark:border-navy-600 bg-slate-50 dark:bg-navy-700 overflow-hidden">
                                            <!-- Meal Header -->
                                            <div class="flex items-center justify-between bg-white dark:bg-navy-600 px-4 py-3 border-b border-slate-200 dark:border-navy-500">
                                                <div class="flex items-center space-x-3">
                                                    <div class="flex items-center justify-center size-8 rounded-full bg-slate-100 dark:bg-navy-500 text-slate-600 dark:text-navy-200 text-sm font-medium">
                                                        {{ $mealIndex + 1 }}
                                                    </div>
                                                    <div>
                                                        <h3 class="font-medium text-slate-800 dark:text-navy-50">
                                                            {{ $meal->title ?: 'Meal Option ' . ($mealIndex + 1) }}
                                                        </h3>
                                                        @if($meal->description)
                                                            <p class="text-sm text-slate-500 dark:text-navy-300">{{ $meal->description }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                @if($meal->mealItems->count() > 0)
                                                    <span class="inline-flex items-center rounded-full bg-info/10 px-2 py-1 text-xs font-medium text-info">
                                                        {{ $meal->mealItems->count() }} {{ Str::plural('item', $meal->mealItems->count()) }}
                                                    </span>
                                                @endif
                                            </div>

                                            <!-- Meal Content -->
                                            <div class="p-4">
                                                @if($meal->note)
                                                    <div class="mb-4 p-3 rounded-lg bg-warning/5 border-l-4 border-warning">
                                                        <p class="text-sm text-slate-700 dark:text-navy-200">
                                                            <span class="font-medium text-warning">Note:</span> {{ $meal->note }}
                                                        </p>
                                                    </div>
                                                @endif

                                                @if($meal->mealItems->count() > 0)
                                                    <div class="space-y-3">
                                                        <h4 class="text-sm font-medium text-slate-600 dark:text-navy-100 mb-3">Food Items</h4>
                                                        <div class="grid gap-3">
                                                            @foreach($meal->mealItems as $item)
                                                                <div class="flex items-center justify-between p-3 rounded-lg bg-white dark:bg-navy-600 border border-slate-200 dark:border-navy-500">
                                                                    <div class="flex items-center space-x-3">
                                                                        <div class="flex items-center justify-center size-8 rounded-full bg-success/10 text-success">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/>
                                                                            </svg>
                                                                        </div>
                                                                        <div>
                                                                            <p class="font-medium text-slate-800 dark:text-navy-50">{{ $item->foodItem->name }}</p>
                                                                            @if($item->notes)
                                                                                <p class="text-sm text-slate-500 dark:text-navy-300">{{ $item->notes }}</p>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="text-right">
                                                                        @if($item->portion_size)
                                                                            <span class="inline-flex items-center rounded-full bg-primary/10 px-3 py-1 text-sm font-medium text-primary dark:bg-accent/10 dark:text-accent">
                                                                                {{ $item->portion_size }}
                                                                            </span>
                                                                        @endif
                                                                        <p class="text-xs text-slate-500 dark:text-navy-300 mt-1">{{ $item->foodItem->unit }}</p>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="text-center py-8">
                                                        <div class="flex items-center justify-center size-12 rounded-full bg-slate-100 dark:bg-navy-500 mx-auto mb-3">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-slate-400 dark:text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                                            </svg>
                                                        </div>
                                                        <p class="text-slate-500 dark:text-navy-300">No food items configured for this meal</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                @if($mealPlan->meals->count() === 0)
                    <div class="card">
                        <div class="p-8 text-center">
                            <div class="flex items-center justify-center size-16 rounded-full bg-slate-100 dark:bg-navy-600 mx-auto mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-8 text-slate-400 dark:text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-slate-800 dark:text-navy-50 mb-2">No Meals Configured</h3>
                            <p class="text-slate-500 dark:text-navy-300 mb-4">This meal plan doesn't have any meals set up yet.</p>
                            <a href="{{ route('dietitian.meal-plans.edit', $mealPlan->id) }}"
                                class="btn bg-primary font-medium text-white hover:bg-primary-focus dark:bg-accent dark:hover:bg-accent-focus">
                                Add Meals
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-span-12 lg:col-span-4">
                <!-- Quick Stats -->
                <div class="card mb-6">
                    <div class="border-b border-slate-200 px-4 py-4 dark:border-navy-500 sm:px-5">
                        <h2 class="text-lg font-medium text-slate-700 dark:text-navy-100">Quick Stats</h2>
                    </div>
                    <div class="p-4 sm:p-5 space-y-4">
                        @php
                            $totalItems = $mealPlan->meals->sum(function($meal) { return $meal->mealItems->count(); });
                            $mealTypesWithMeals = $mealPlan->meals->groupBy('type')->keys()->count();
                        @endphp
                        
                        <div class="flex items-center justify-between">
                            <span class="text-slate-600 dark:text-navy-100">Total Meals</span>
                            <span class="font-semibold text-slate-800 dark:text-navy-50">{{ $mealPlan->meals->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-600 dark:text-navy-100">Total Food Items</span>
                            <span class="font-semibold text-slate-800 dark:text-navy-50">{{ $totalItems }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-600 dark:text-navy-100">Meal Categories</span>
                            <span class="font-semibold text-slate-800 dark:text-navy-50">{{ $mealTypesWithMeals }} of 5</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-600 dark:text-navy-100">Last Updated</span>
                            <span class="font-semibold text-slate-800 dark:text-navy-50">{{ $mealPlan->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="card">
                    <div class="border-b border-slate-200 px-4 py-4 dark:border-navy-500 sm:px-5">
                        <h2 class="text-lg font-medium text-slate-700 dark:text-navy-100">Actions</h2>
                    </div>
                    <div class="p-4 sm:p-5 space-y-3">
                        <a href="{{ route('dietitian.meal-plans.edit', $mealPlan->id) }}"
                            class="btn w-full bg-primary font-medium text-white hover:bg-primary-focus dark:bg-accent dark:hover:bg-accent-focus">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit Meal Plan
                        </a>
                        <button onclick="console.log('Print to be done')" 
                            class="btn w-full border border-slate-300 font-medium text-slate-700 hover:bg-slate-150 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                            </svg>
                            Print Plan
                        </button>
                        <form method="POST" action="{{ route('dietitian.meal-plans.destroy', $mealPlan->id) }}" 
                            onsubmit="return confirm('Are you sure you want to delete this meal plan?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                class="btn w-full bg-error font-medium text-white hover:bg-error-focus">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Delete Plan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>