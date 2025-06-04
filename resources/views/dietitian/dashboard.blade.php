<?php /** @var \Illuminate\Support\Collection $latestProgressEntries */ ?>

<x-app-layout title="Dietitian Dashboard" is-header-blur="true">
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="mt-4 grid grid-cols-12 gap-4 sm:mt-5 sm:gap-5 lg:mt-6 lg:gap-6">
            <!-- Left main content -->
            <div class="col-span-12 lg:col-span-8 xl:col-span-9">
                <!-- Welcome Card -->
                <div class="card col-span-12 bg-gradient-to-r from-teal-800 to-teal-700 p-5 text-white">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-xl font-semibold">Welcome, {{ Auth::user()->name }}</h3>
                            <p class="mt-2">Here is a quick summary of your patients.</p>
                            <p>Keep helping people eat better!</p>
                        </div>
                        <img src="{{ asset('images/illustrations/doctor.svg') }}" class="h-32" alt="Dietitian" />
                    </div>
                </div>

                <!-- Statistics -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-6">
                    <div class="card p-4 text-center">
                        <p class="text-sm text-slate-500">Total Patients</p>
                        <p class="text-xl font-bold text-slate-700 dark:text-navy-100">{{ $totalPatients ?? '---' }}</p>
                    </div>
                    <div class="card p-4 text-center">
                        <p class="text-sm text-slate-500">Pending Invitations</p>
                        <p class="text-xl font-bold text-slate-700 dark:text-navy-100">--</p>
                    </div>
                    <div class="card p-4 text-center">
                        <p class="text-sm text-slate-500">Active Logs This Week</p>
                        <p class="text-xl font-bold text-slate-700 dark:text-navy-100">--</p>
                    </div>
                </div>

                <!-- Latest Progress Entries -->
                <div class="mt-6 card p-5">
                    <h2 class="text-lg font-semibold text-slate-700 dark:text-navy-100 mb-4">Latest Progress Entries</h2>
                    @forelse($latestProgressEntries ?? [] as $entry)
                        <div class="flex justify-between items-center py-2 border-b last:border-none">
                            <div>
                                <p class="font-medium text-slate-800 dark:text-navy-100">
                                    {{ $entry->patient->user->name ?? 'N/A' }}
                                </p>
                                <p class="text-xs text-slate-500 dark:text-navy-300">
                                    {{ $entry->weight }} kg on {{ $entry->measurement_date }}
                                </p>
                            </div>
                            <a href="#" class="text-xs text-primary hover:underline">View</a>
                        </div>
                    @empty
                        <p class="text-slate-500">No recent entries yet.</p>
                    @endforelse
                </div>
            </div>

            <!-- Right sidebar -->
<div class="col-span-12 lg:col-span-4 xl:col-span-3" x-data="{ openModal: null }">
    <div class="card p-5">
        <h3 class="font-medium text-slate-700 dark:text-navy-100 mb-4 flex items-center justify-between">
            Quick Actions
            <button @click="openModal = null"
                class="btn size-6 p-0 rounded-full bg-slate-200 dark:bg-navy-600 hover:bg-slate-300 dark:hover:bg-navy-500 focus:outline-none"
                title="Reset">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-600 dark:text-navy-100"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </h3>

        <ul class="space-y-3 text-sm font-medium text-slate-700 dark:text-navy-100">
            <li>
                <a href="{{ route('dietitian.patients.invite') }}"
                    class="hover:text-primary transition-colors block">
                     Invite New Patient
                </a>
            </li>
            <li>
                <button @click="openModal = 'meal'"
                    class="w-full text-left hover:text-primary focus:text-primary transition-colors">
                    🍽️ Create Meal Plan
                </button>
            </li>
            <li>
                <a href="{{ route('dietitian.dashboard') }}"
                    class="hover:text-primary transition-colors block">
                    👥 View All Patients
                </a>
            </li>
            <li>
                <a href="{{ route('dietitian.dashboard') }}"
                    class="hover:text-primary transition-colors block">
                    ⚙️ Update Your Profile
                </a>
            </li>
        </ul>
    </div>

    <!-- Placeholder Modals (enhance later) -->
    <template x-if="openModal === 'invite'">
        <div class="fixed inset-0 bg-black/50 z-40 flex items-center justify-center">
            <div class="card w-full max-w-md p-6 bg-white dark:bg-navy-700 z-50 relative">
                <h2 class="text-lg font-semibold text-slate-700 dark:text-navy-100 mb-4">Invite Patient</h2>
                <p class="text-sm text-slate-500 dark:text-navy-200">This will open the invite form soon...</p>
                <div class="mt-4 flex justify-end">
                    <button @click="openModal = null"
                        class="btn px-4 py-1 bg-slate-200 dark:bg-navy-600 hover:bg-slate-300 dark:hover:bg-navy-500 rounded">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </template>

    <template x-if="openModal === 'meal'">
        <div class="fixed inset-0 bg-black/50 z-40 flex items-center justify-center">
            <div class="card w-full max-w-md p-6 bg-white dark:bg-navy-700 z-50 relative">
                <h2 class="text-lg font-semibold text-slate-700 dark:text-navy-100 mb-4">Create Meal Plan</h2>
                <p class="text-sm text-slate-500 dark:text-navy-200">Meal plan creation coming soon...</p>
                <div class="mt-4 flex justify-end">
                    <button @click="openModal = null"
                        class="btn px-4 py-1 bg-slate-200 dark:bg-navy-600 hover:bg-slate-300 dark:hover:bg-navy-500 rounded">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </template>
</div>

        </div>
    </main>
</x-app-layout>
