<x-app-layout title="Manage Availability" is-header-blur="true">
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <!-- Breadcrumb -->
        <div class="flex items-center space-x-4 py-5 lg:py-6">
            <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">Manage Availability</h2>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </li>
                <li>Availability</li>
            </ul>
        </div>

        <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6" x-data="availabilityManager()">
            <!-- Main Calendar Section -->
            <div class="col-span-12 lg:col-span-8">
                <div class="card">
                    <div class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                        <div class="flex items-center space-x-3">
                            <div class="flex items-center justify-center size-10 rounded-full bg-primary/10 text-primary dark:bg-accent/15 dark:text-accent">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-medium text-slate-700 dark:text-navy-100">Weekly Schedule</h2>
                                <p class="text-sm text-slate-500 dark:text-navy-300">Set your regular availability for patient bookings</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button @click="openQuickAdd()"
                                class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                </svg>
                                Add Time Slot
                            </button>
                            {{-- <button @click="openBulkEditor()"
                                class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-700 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Bulk Edit
                            </button> --}}
                        </div>
                    </div>

                    <div class="p-4 sm:p-5">
                        <!-- Alert Messages -->
                        <div x-show="alert.show" x-transition
                            :class="alert.type === 'success' ? 'border-success bg-success/10 text-success' : 'border-error bg-error/10 text-error'"
                            class="alert mb-5 flex rounded-lg border px-4 py-4 sm:px-5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 20 20" fill="currentColor" x-show="alert.type === 'success'">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 20 20" fill="currentColor" x-show="alert.type === 'error'">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="ml-2" x-text="alert.message"></span>
                        </div>

                        <!-- Loading State -->
                        <div x-show="loading" class="text-center py-12">
                            <div class="flex items-center justify-center size-12 rounded-full bg-slate-100 dark:bg-navy-600 mx-auto mb-4">
                                <svg class="animate-spin size-6 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                            <p class="text-slate-500 dark:text-navy-300">Loading your schedule...</p>
                        </div>

                        <!-- Weekly Schedule Grid -->
                        <div class="space-y-5" x-show="!loading">
                            <template x-for="(day, dayNumber) in weeklySchedule" :key="dayNumber">
                                <div class="card overflow-hidden border border-slate-200 dark:border-navy-600">
                                    <!-- Day Header -->
                                    <div class="flex items-center justify-between bg-slate-50 dark:bg-navy-700/50 px-5 py-4 border-b border-slate-200 dark:border-navy-600">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex items-center justify-center size-12 rounded-xl bg-primary/10 text-primary dark:bg-accent/15 dark:text-accent">
                                                <span class="text-lg font-bold" x-text="day.name.charAt(0)"></span>
                                            </div>
                                            <div>
                                                <h3 class="text-lg font-semibold text-slate-800 dark:text-navy-50" x-text="day.name"></h3>
                                                <p class="text-sm text-slate-500 dark:text-navy-300">
                                                    <span x-text="day.slots.length"></span> time slot<span x-show="day.slots.length !== 1">s</span>
                                                    <template x-if="day.slots.length > 0">
                                                        <span> • Available for bookings</span>
                                                    </template>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <template x-if="day.slots.length > 0">
                                                <div class="badge bg-success/10 text-success dark:bg-success/15">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                    Active
                                                </div>
                                            </template>
                                            <template x-if="day.slots.length === 0">
                                                <div class="badge bg-slate-100 text-slate-500 dark:bg-navy-600 dark:text-navy-300">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"/>
                                                    </svg>
                                                    Unavailable
                                                </div>
                                            </template>
                                            <button type="button" @click="openQuickAdd(dayNumber)"
                                                    class="btn size-8 rounded-full bg-primary text-white text-sm hover:bg-primary-focus">+</button>
                                        </div>
                                    </div>

                                    <!-- Time Slots Grid -->
                                    <div class="p-5">
                                        <template x-if="day.slots.length > 0">
                                            <div class="grid gap-3 sm:grid-cols-2">
                                                <template x-for="slot in day.slots" :key="slot.id">
                                                    <div class="group relative rounded-lg border border-slate-200 bg-white p-4 transition-all hover:border-primary/30 hover:shadow-sm dark:border-navy-600 dark:bg-navy-800 dark:hover:border-accent/30">
                                                        <!-- Time Display -->
                                                        <div class="flex items-center space-x-3 mb-3">
                                                            <div class="flex items-center justify-center size-10 rounded-lg bg-primary/10 text-primary dark:bg-accent/15 dark:text-accent">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                                </svg>
                                                            </div>
                                                            <div>
                                                                <div class="font-semibold text-slate-800 dark:text-navy-50" x-text="formatTimeRange(slot.start_time, slot.end_time)"></div>
                                                                <div class="text-xs text-slate-500 dark:text-navy-400">
                                                                    <span x-text="calculateDuration(slot.start_time, slot.end_time)"></span> duration
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Action Buttons -->
                                                        <div class="flex items-center justify-end space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                            <button @click="editSlot(slot)" type="button"
                                                                class="btn size-8 rounded-full p-0 hover:bg-info/20 text-info transition-colors"
                                                                title="Edit time slot">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                                </svg>
                                                            </button>
                                                            <button @click="deleteSlot(slot.id)" type="button"
                                                                class="btn size-8 rounded-full p-0 hover:bg-error/20 text-error transition-colors"
                                                                title="Delete time slot">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </template>

                                        <!-- Empty State -->
                                        <template x-if="day.slots.length === 0">
                                            <div class="flex flex-col items-center justify-center py-8">
                                                <div class="flex items-center justify-center size-16 rounded-full bg-slate-100 dark:bg-navy-600 mb-4">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-8 text-slate-400 dark:text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                </div>
                                                <h4 class="text-lg font-medium text-slate-700 dark:text-navy-100 mb-2">No availability set</h4>
                                                <p class="text-slate-500 dark:text-navy-300 text-center mb-4">
                                                    You haven't set any time slots for <span x-text="day.name" class="font-medium"></span> yet.
                                                </p>
                                                <button @click="openQuickAdd(dayNumber)"
                                                    class="btn rounded-full border border-primary text-primary hover:bg-primary/10 focus:bg-primary/10 active:bg-primary/15 dark:border-accent dark:text-accent dark:hover:bg-accent/10">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                    </svg>
                                                    Add &nbsp;<span x-text="day.name"></span>&nbsp; Availability
                                                </button>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Summary Sidebar -->
            <div class="col-span-12 lg:col-span-4">
                <!-- Schedule Overview Card -->
                <div class="card">
                    <div class="border-b border-slate-200 px-4 py-4 dark:border-navy-500 sm:px-5">
                        <div class="flex items-center space-x-3">
                            <div class="flex items-center justify-center size-10 rounded-full bg-indigo-100 text-indigo-600 dark:bg-indigo-900/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-medium text-slate-700 dark:text-navy-100">Schedule Overview</h2>
                                <p class="text-sm text-slate-500 dark:text-navy-300">Your weekly availability summary</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 sm:p-5">
                        <!-- Stats Grid -->
                        <div class="grid grid-cols-1 gap-4 mb-6">
                            <div class="flex items-center justify-between p-4 rounded-lg bg-slate-50 dark:bg-navy-600/25">
                                <div class="flex items-center space-x-3">
                                    <div class="flex items-center justify-center size-10 rounded-lg bg-blue-100 text-blue-600 dark:bg-blue-900/30">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-slate-600 dark:text-navy-300">Total Time Slots</p>
                                        <p class="text-2xl font-bold text-slate-800 dark:text-navy-50" x-text="summary.totalSlots"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between p-4 rounded-lg bg-slate-50 dark:bg-navy-600/25">
                                <div class="flex items-center space-x-3">
                                    <div class="flex items-center justify-center size-10 rounded-lg bg-green-100 text-green-600 dark:bg-green-900/30">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-slate-600 dark:text-navy-300">Active Days</p>
                                        <p class="text-2xl font-bold text-slate-800 dark:text-navy-50">
                                            <span x-text="summary.daysWithAvailability"></span><span class="text-lg text-slate-500">/7</span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between p-4 rounded-lg bg-slate-50 dark:bg-navy-600/25">
                                <div class="flex items-center space-x-3">
                                    <div class="flex items-center justify-center size-10 rounded-lg" 
                                         :class="summary.totalSlots > 0 ? 'bg-success/10 text-success' : 'bg-warning/10 text-warning'">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-show="summary.totalSlots > 0">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-show="summary.totalSlots === 0">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-slate-600 dark:text-navy-300">Status</p>
                                        <div x-show="summary.totalSlots > 0">
                                            <span class="inline-flex items-center rounded-full bg-success/10 px-2.5 py-0.5 text-xs font-medium text-success">
                                                <svg class="mr-1 size-2" fill="currentColor" viewBox="0 0 8 8">
                                                    <circle cx="4" cy="4" r="3"/>
                                                </svg>
                                                Active Schedule
                                            </span>
                                        </div>
                                        <div x-show="summary.totalSlots === 0">
                                            <span class="inline-flex items-center rounded-full bg-warning/10 px-2.5 py-0.5 text-xs font-medium text-warning">
                                                <svg class="mr-1 size-2" fill="currentColor" viewBox="0 0 8 8">
                                                    <circle cx="4" cy="4" r="3"/>
                                                </svg>
                                                No Schedule
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Daily Breakdown -->
                        <template x-if="summary.totalSlots > 0">
                            <div>
                                <h3 class="text-sm font-semibold text-slate-700 dark:text-navy-100 mb-3 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    Daily Breakdown
                                </h3>
                                <div class="space-y-2">
                                    <template x-for="(day, dayNumber) in weeklySchedule" :key="dayNumber">
                                        <template x-if="day.slots.length > 0">
                                            <div class="flex items-center justify-between p-3 rounded-lg bg-white dark:bg-navy-700/50 border border-slate-200 dark:border-navy-600">
                                                <div class="flex items-center space-x-3">
                                                    <div class="flex items-center justify-center size-8 rounded-lg bg-primary/10 text-primary dark:bg-accent/15 dark:text-accent text-sm font-medium">
                                                        <span x-text="day.name.charAt(0)"></span>
                                                    </div>
                                                    <div>
                                                        <p class="font-medium text-slate-700 dark:text-navy-100" x-text="day.name.substring(0, 3)"></p>
                                                        <p class="text-xs text-slate-500 dark:text-navy-400">
                                                            <span x-text="day.slots.length"></span> slot<span x-show="day.slots.length !== 1">s</span>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <template x-if="day.slots.length > 0">
                                                        <div class="text-xs text-slate-600 dark:text-navy-300" x-text="getEarliestLatestTime(day.slots)"></div>
                                                    </template>
                                                </div>
                                            </div>
                                        </template>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Tips Card -->
                <div class="card mt-5">
                    <div class="border-b border-slate-200 px-4 py-4 dark:border-navy-500 sm:px-5">
                        <div class="flex items-center space-x-3">
                            <div class="flex items-center justify-center size-10 rounded-full bg-amber-100 text-amber-600 dark:bg-amber-900/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-medium text-slate-700 dark:text-navy-100">Pro Tips</h2>
                                <p class="text-sm text-slate-500 dark:text-navy-300">Best practices for scheduling</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 sm:p-5">
                        <div class="space-y-4 text-sm">
                            <div class="flex items-start space-x-3">
                                <div class="flex items-center justify-center size-6 rounded-full bg-green-100 text-green-600 dark:bg-green-900/30 mt-0.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-slate-700 dark:text-navy-100">Regular Schedule</p>
                                    <p class="text-slate-600 dark:text-navy-300">Set consistent weekly hours that patients can rely on for booking.</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-3">
                                <div class="flex items-center justify-center size-6 rounded-full bg-blue-100 text-blue-600 dark:bg-blue-900/30 mt-0.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-slate-700 dark:text-navy-100">Multiple Slots</p>
                                    <p class="text-slate-600 dark:text-navy-300">Add morning and afternoon slots to give patients more booking options.</p>
                                </div>
                            </div>
                            
                            {{-- <div class="flex items-start space-x-3">
                                <div class="flex items-center justify-center size-6 rounded-full bg-purple-100 text-purple-600 dark:bg-purple-900/30 mt-0.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-slate-700 dark:text-navy-100">Bulk Editing</p>
                                    <p class="text-slate-600 dark:text-navy-300">Use bulk edit to quickly set up your entire week's schedule at once.</p>
                                </div>
                            </div> --}}
                            
                            <div class="flex items-start space-x-3">
                                <div class="flex items-center justify-center size-6 rounded-full bg-orange-100 text-orange-600 dark:bg-orange-900/30 mt-0.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-slate-700 dark:text-navy-100">Patient Visibility</p>
                                    <p class="text-slate-600 dark:text-navy-300">Only your available time slots will be visible to patients when booking.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Add Modal -->
            <div x-show="modals.quickAdd" x-transition.opacity
                class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
                x-cloak>
                <div class="absolute inset-0 bg-slate-900/60 transition-opacity" @click="modals.quickAdd = false"></div>
                <div class="relative w-full max-w-lg origin-bottom rounded-lg bg-white transition-all dark:bg-navy-700 sm:max-w-xl">
                    <div class="flex items-center justify-between border-b border-slate-200 px-4 py-4 dark:border-navy-500 sm:px-5">
                        <div class="flex items-center space-x-3">
                            <div class="flex items-center justify-center size-10 rounded-full bg-primary/10 text-primary dark:bg-accent/15 dark:text-accent">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100">Add Time Slot</h3>
                                <p class="text-sm text-slate-500 dark:text-navy-300">Set your availability for patient bookings</p>
                            </div>
                        </div>
                        <button @click="modals.quickAdd = false"
                            class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 text-slate-500 dark:text-navy-300 dark:hover:bg-navy-300/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    <div class="p-4 sm:p-5">
                        <form @submit.prevent="submitQuickAdd()">
                            <div class="mb-4">
                                <label class="block">
                                    <span class="font-medium text-slate-600 dark:text-navy-100">Day of Week</span>
                                    <select x-model="quickAddForm.day_of_week" required
                                        class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                                        <option value="" disabled>Select day of the week</option>
                                        <template x-for="(day, dayNumber) in weeklySchedule" :key="dayNumber">
                                            <option :value="dayNumber" x-text="day.name"></option>
                                        </template>
                                    </select>
                                </label>
                            </div>

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 mb-6">
                                <label class="block">
                                    <span class="font-medium text-slate-600 dark:text-navy-100">Start Time</span>
                                    <select x-model="quickAddForm.start_time" required
                                        class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                                        <option value="" disabled>Select start time</option>
                                        <template x-for="(display, time) in timeOptions" :key="time">
                                            <option :value="time" x-text="display"></option>
                                        </template>
                                    </select>
                                </label>

                                <label class="block">
                                    <span class="font-medium text-slate-600 dark:text-navy-100">End Time</span>
                                    <select x-model="quickAddForm.end_time" required
                                        class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                                        <option value="" disabled>Select end time</option>
                                        <template x-for="(display, time) in timeOptions" :key="time">
                                            <option :value="time" x-text="display"></option>
                                        </template>
                                    </select>
                                </label>
                            </div>

                            <div class="flex items-center justify-end space-x-2">
                                <button type="button" @click="modals.quickAdd = false"
                                    class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-700 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                                    Cancel
                                </button>
                                <button type="submit" :disabled="submitting"
                                    class="btn min-w-[7rem] bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-show="!submitting">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    <svg class="animate-spin size-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" x-show="submitting">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span x-show="!submitting">Add Time Slot</span>
                                    <span x-show="submitting">Adding...</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Edit Modal -->
            <div x-show="modals.edit" x-transition.opacity
                class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
                x-cloak>
                <div class="absolute inset-0 bg-slate-900/60 transition-opacity" @click="modals.edit = false"></div>
                <div class="relative w-full max-w-lg origin-bottom rounded-lg bg-white transition-all dark:bg-navy-700 sm:max-w-xl">
                    <div class="flex items-center justify-between border-b border-slate-200 px-4 py-4 dark:border-navy-500 sm:px-5">
                        <div class="flex items-center space-x-3">
                            <div class="flex items-center justify-center size-10 rounded-full bg-info/10 text-info dark:bg-info/15">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100">Edit Time Slot</h3>
                                <p class="text-sm text-slate-500 dark:text-navy-300">Update your availability settings</p>
                            </div>
                        </div>
                        <button @click="modals.edit = false"
                            class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 text-slate-500 dark:text-navy-300 dark:hover:bg-navy-300/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    <div class="p-4 sm:p-5">
                        <form @submit.prevent="submitEdit()">
                            <div class="mb-4">
                                <label class="block">
                                    <span class="font-medium text-slate-600 dark:text-navy-100">Day of Week</span>
                                    <select x-model="editForm.day_of_week" required
                                        class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                                        <template x-for="(day, dayNumber) in weeklySchedule" :key="dayNumber">
                                            <option :value="dayNumber" x-text="day.name"></option>
                                        </template>
                                    </select>
                                </label>
                            </div>

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 mb-6">
                                <label class="block">
                                    <span class="font-medium text-slate-600 dark:text-navy-100">Start Time</span>
                                    <select x-model="editForm.start_time" required
                                        class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                                        <template x-for="(display, time) in timeOptions" :key="time">
                                            <option :value="time" x-text="display"></option>
                                        </template>
                                    </select>
                                </label>

                                <label class="block">
                                    <span class="font-medium text-slate-600 dark:text-navy-100">End Time</span>
                                    <select x-model="editForm.end_time" required
                                        class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                                        <template x-for="(display, time) in timeOptions" :key="time">
                                            <option :value="time" x-text="display"></option>
                                        </template>
                                    </select>
                                </label>
                            </div>

                            <div class="flex items-center justify-end space-x-2">
                                <button type="button" @click="modals.edit = false"
                                    class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-700 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                                    Cancel
                                </button>
                                <button type="submit" :disabled="submitting"
                                    class="btn min-w-[7rem] bg-info font-medium text-white hover:bg-info-focus focus:bg-info-focus active:bg-info-focus/90 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-show="!submitting">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <svg class="animate-spin size-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" x-show="submitting">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span x-show="!submitting">Update Slot</span>
                                    <span x-show="submitting">Updating...</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Enhanced Bulk Edit Modal -->
            <div x-show="modals.bulkEdit" x-transition.opacity
                class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
                x-cloak>
                <div class="absolute inset-0 bg-slate-900/60 transition-opacity" @click="modals.bulkEdit = false"></div>
                <div class="relative w-full max-w-5xl origin-bottom rounded-lg bg-white transition-all dark:bg-navy-700 max-h-[90vh] overflow-hidden flex flex-col">
                    <div class="flex items-center justify-between border-b border-slate-200 px-4 py-4 dark:border-navy-500 sm:px-5 flex-shrink-0">
                        <div class="flex items-center space-x-3">
                            <div class="flex items-center justify-center size-10 rounded-full bg-purple-100 text-purple-600 dark:bg-purple-900/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100">Bulk Edit Weekly Schedule</h3>
                                <p class="text-sm text-slate-500 dark:text-navy-300">Set up your entire week's availability at once</p>
                            </div>
                        </div>
                        <button @click="modals.bulkEdit = false"
                            class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 text-slate-500 dark:text-navy-300 dark:hover:bg-navy-300/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="flex-1 overflow-y-auto p-4 sm:p-5">
                        <form @submit.prevent="submitBulkEdit()">
                            <div class="space-y-6">
                                <template x-for="(day, dayIndex) in bulkEditForm" :key="dayIndex">
                                    <div class="card overflow-hidden border border-slate-200 dark:border-navy-600">
                                        <!-- Day Header -->
                                        <div class="flex items-center justify-between bg-slate-50 dark:bg-navy-700/50 px-4 py-3 border-b border-slate-200 dark:border-navy-600">
                                            <div class="flex items-center space-x-3">
                                                <div class="flex items-center justify-center size-10 rounded-xl bg-primary/10 text-primary dark:bg-accent/15 dark:text-accent">
                                                    <span class="font-bold" x-text="day.name.charAt(0)"></span>
                                                </div>
                                                <div>
                                                    <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100" x-text="day.name"></h3>
                                                    <p class="text-sm text-slate-500 dark:text-navy-300">
                                                        <span x-text="day.slots.length"></span> time slot<span x-show="day.slots.length !== 1">s</span>
                                                    </p>
                                                </div>
                                            </div>
                                            <button type="button" @click="addSlotToBulkDay(dayIndex)"
                                                class="btn size-9 rounded-full bg-primary text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                </svg>
                                            </button>
                                        </div>

                                        <!-- Time Slots -->
                                        <div class="p-4">
                                            <template x-if="day.slots.length > 0">
                                                <div class="space-y-3">
                                                    <template x-for="(slot, slotIndex) in day.slots" :key="slotIndex">
                                                        <div class="flex items-end gap-4 p-4 rounded-lg bg-white dark:bg-navy-700/50 border border-slate-200 dark:border-navy-600">
                                                            <div class="flex-1">
                                                                <label class="block">
                                                                    <span class="text-sm font-medium text-slate-600 dark:text-navy-100">Start Time</span>
                                                                    <select x-model="slot.start_time"
                                                                        class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                                                                        <option value="">Select start time</option>
                                                                        <template x-for="(display, time) in timeOptions" :key="time">
                                                                            <option :value="time" x-text="display"></option>
                                                                        </template>
                                                                    </select>
                                                                </label>
                                                            </div>

                                                            <div class="flex-1">
                                                                <label class="block">
                                                                    <span class="text-sm font-medium text-slate-600 dark:text-navy-100">End Time</span>
                                                                    <select x-model="slot.end_time"
                                                                        class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                                                                        <option value="">Select end time</option>
                                                                        <template x-for="(display, time) in timeOptions" :key="time">
                                                                            <option :value="time" x-text="display"></option>
                                                                        </template>
                                                                    </select>
                                                                </label>
                                                            </div>

                                                            <div class="flex-shrink-0">
                                                                <button type="button" @click="removeSlotFromBulkDay(dayIndex, slotIndex)"
                                                                    class="btn size-10 rounded-full bg-error text-white hover:bg-error-focus focus:bg-error-focus active:bg-error-focus/90 mb-1.5">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </template>
                                                </div>
                                            </template>

                                            <!-- Empty state for days with no slots -->
                                            <template x-if="day.slots.length === 0">
                                                <div class="text-center py-8">
                                                    <div class="flex items-center justify-center size-12 rounded-full bg-slate-100 dark:bg-navy-600 mx-auto mb-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-slate-400 dark:text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                    </div>
                                                    <p class="text-slate-500 dark:text-navy-300 mb-3">
                                                        No time slots for <span x-text="day.name" class="font-medium"></span>
                                                    </p>
                                                    <button type="button" @click="addSlotToBulkDay(dayIndex)"
                                                        class="btn rounded-full border border-primary text-primary hover:bg-primary/10 focus:bg-primary/10 active:bg-primary/15 dark:border-accent dark:text-accent dark:hover:bg-accent/10">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                        </svg>
                                                        Add &nbsp;<span x-text="day.name"></span>&nbsp; Time Slot
                                                    </button>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <div class="flex items-center justify-end space-x-2 pt-6 mt-6 border-t border-slate-200 dark:border-navy-500">
                                <button type="button" @click="modals.bulkEdit = false"
                                    class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-700 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                                    Cancel
                                </button>
                                <button type="submit" :disabled="submitting"
                                    class="btn min-w-[7rem] bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-show="!submitting">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <svg class="animate-spin size-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" x-show="submitting">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span x-show="!submitting">Save Weekly Schedule</span>
                                    <span x-show="submitting">Saving...</span>
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
        function availabilityManager() {
            return {
                loading: true,
                submitting: false,
                weeklySchedule: {},
                summary: {
                    totalSlots: 0,
                    daysWithAvailability: 0
                },
                alert: {
                    show: false,
                    type: 'success',
                    message: ''
                },
                modals: {
                    quickAdd: false,
                    edit: false,
                    bulkEdit: false
                },
                quickAddForm: {
                    day_of_week: '',
                    start_time: '',
                    end_time: ''
                },
                editForm: {
                    id: null,
                    day_of_week: '',
                    start_time: '',
                    end_time: ''
                },
                bulkEditForm: [],
                timeOptions: {},

                async init() {
                    await this.loadAvailability();
                },

                async loadAvailability() {
                    this.loading = true;
                    try {
                        const response = await axios.get('{{ route("dietitian.availability.data") }}');

                        if (response.data.success) {
                            this.weeklySchedule = response.data.weeklySchedule;
                            this.timeOptions = response.data.timeOptions;
                            this.updateSummary();
                        }
                    } catch (error) {
                        this.showAlert('error', 'Failed to load availability data');
                        console.error('Load error:', error);
                    } finally {
                        this.loading = false;
                    }
                },

                updateSummary() {
                    let totalSlots = 0;
                    let daysWithAvailability = 0;

                    Object.values(this.weeklySchedule).forEach(day => {
                        totalSlots += day.slots.length;
                        if (day.slots.length > 0) {
                            daysWithAvailability++;
                        }
                    });

                    this.summary = { totalSlots, daysWithAvailability };
                },

                formatTimeRange(startTime, endTime) {
                    return this.formatTime12Hour(startTime) + ' - ' + this.formatTime12Hour(endTime);
                },

                formatTime12Hour(time) {
                    if (!time) return '';
                    const [hours, minutes] = time.split(':');
                    const hour = parseInt(hours);
                    const ampm = hour >= 12 ? 'PM' : 'AM';
                    const displayHour = hour % 12 || 12;
                    return `${displayHour}:${minutes} ${ampm}`;
                },

                calculateDuration(startTime, endTime) {
                    if (!startTime || !endTime) return '';
                    const start = new Date(`2000-01-01 ${startTime}`);
                    const end = new Date(`2000-01-01 ${endTime}`);
                    const diffMs = end - start;
                    const diffHours = Math.floor(diffMs / (1000 * 60 * 60));
                    const diffMinutes = Math.floor((diffMs % (1000 * 60 * 60)) / (1000 * 60));
                    
                    if (diffHours > 0 && diffMinutes > 0) {
                        return `${diffHours}h ${diffMinutes}m`;
                    } else if (diffHours > 0) {
                        return `${diffHours}h`;
                    } else {
                        return `${diffMinutes}m`;
                    }
                },

                getEarliestLatestTime(slots) {
                    if (!slots || slots.length === 0) return '';
                    const times = slots.map(slot => ({ start: slot.start_time, end: slot.end_time }));
                    const earliest = times.reduce((min, slot) => slot.start < min ? slot.start : min, times[0].start);
                    const latest = times.reduce((max, slot) => slot.end > max ? slot.end : max, times[0].end);
                    return `${this.formatTime12Hour(earliest)} - ${this.formatTime12Hour(latest)}`;
                },

                openQuickAdd(dayNumber = '') {
                    this.quickAddForm = {
                        day_of_week: dayNumber.toString(),
                        start_time: '',
                        end_time: ''
                    };
                    this.modals.quickAdd = true;
                },

                async submitQuickAdd() {
                    this.submitting = true;
                    try {
                        const response = await axios.post('{{ route("dietitian.availability.store") }}', this.quickAddForm, {
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        });

                        if (response.data.success) {
                            this.showAlert('success', response.data.message || 'Time slot added successfully');
                            this.modals.quickAdd = false;
                            await this.loadAvailability();
                        }
                    } catch (error) {
                        if (error.response?.data?.errors) {
                            const errors = Object.values(error.response.data.errors).flat();
                            this.showAlert('error', errors.join(', '));
                        } else {
                            this.showAlert('error', error.response?.data?.message || 'Failed to add time slot');
                        }
                    } finally {
                        this.submitting = false;
                    }
                },

                editSlot(slot) {
                    this.editForm = {
                        id: slot.id,
                        day_of_week: slot.day_of_week.toString(),
                        start_time: slot.start_time,
                        end_time: slot.end_time
                    };
                    this.modals.edit = true;
                },

                async submitEdit() {
                    this.submitting = true;
                    try {
                        const response = await axios.put(`/dietitian/availability/${this.editForm.id}`, {
                            day_of_week: this.editForm.day_of_week,
                            start_time: this.editForm.start_time,
                            end_time: this.editForm.end_time
                        }, {
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        });

                        if (response.data.success) {
                            this.showAlert('success', response.data.message || 'Time slot updated successfully');
                            this.modals.edit = false;
                            await this.loadAvailability();
                        }
                    } catch (error) {
                        if (error.response?.data?.errors) {
                            const errors = Object.values(error.response.data.errors).flat();
                            this.showAlert('error', errors.join(', '));
                        } else {
                            this.showAlert('error', error.response?.data?.message || 'Failed to update time slot');
                        }
                    } finally {
                        this.submitting = false;
                    }
                },

                async deleteSlot(slotId) {
                    if (!confirm('Are you sure you want to delete this time slot? This will affect patient booking availability.')) {
                        return;
                    }

                    try {
                        const response = await axios.delete(`/dietitian/availability/${slotId}`, {
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        });

                        if (response.data.success) {
                            this.showAlert('success', response.data.message || 'Time slot deleted successfully');
                            await this.loadAvailability();
                        }
                    } catch (error) {
                        this.showAlert('error', error.response?.data?.message || 'Failed to delete time slot');
                    }
                },

                openBulkEditor() {
                    // Initialize bulk edit form with current schedule
                    this.bulkEditForm = Object.entries(this.weeklySchedule).map(([dayNumber, day]) => ({
                        name: day.name,
                        number: parseInt(dayNumber),
                        slots: day.slots.map(slot => ({
                            start_time: slot.start_time,
                            end_time: slot.end_time
                        }))
                    }));
                    this.modals.bulkEdit = true;
                },

                addSlotToBulkDay(dayIndex) {
                    this.bulkEditForm[dayIndex].slots.push({
                        start_time: '',
                        end_time: ''
                    });
                },

                removeSlotFromBulkDay(dayIndex, slotIndex) {
                    this.bulkEditForm[dayIndex].slots.splice(slotIndex, 1);
                },

                async submitBulkEdit() {
                    this.submitting = true;
                    try {
                        // Format data for the bulk store endpoint
                        const availability = this.bulkEditForm
                            .filter(day => day.slots.length > 0)
                            .map(day => ({
                                day_of_week: day.number,
                                slots: day.slots.filter(slot => slot.start_time && slot.end_time)
                            }))
                            .filter(day => day.slots.length > 0);

                        const response = await axios.post('{{ route("dietitian.availability.bulk-store") }}', {
                            availability: availability
                        }, {
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        });

                        if (response.data.success) {
                            this.showAlert('success', response.data.message || 'Weekly schedule updated successfully');
                            this.modals.bulkEdit = false;
                            await this.loadAvailability();
                        }
                    } catch (error) {
                        if (error.response?.data?.errors) {
                            const errors = Object.values(error.response.data.errors).flat();
                            this.showAlert('error', errors.join(', '));
                        } else {
                            this.showAlert('error', error.response?.data?.message || 'Failed to update weekly schedule');
                        }
                    } finally {
                        this.submitting = false;
                    }
                },

                showAlert(type, message) {
                    this.alert = { show: true, type, message };
                    setTimeout(() => {
                        this.alert.show = false;
                    }, 5000);
                }
            };
        }
    </script>
    @endslot
</x-app-layout>