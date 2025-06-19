<x-app-layout title="Appointments" is-header-blur="true">
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <!-- Header + Breadcrumbs -->
        <div class="flex items-center space-x-4 py-5 lg:py-6">
            <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
                Appointments
            </h2>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </li>
                <li>Appointments</li>
            </ul>
        </div>

        <!-- Success Alert -->
        @if(session('success'))
            <div class="alert flex rounded-lg border border-success px-4 py-4 text-success sm:px-5 mb-5">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                          d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                          clip-rule="evenodd"/>
                </svg>
                <span>&nbsp;{{ session('success') }}</span>
            </div>
        @endif

        <!-- Error Alert -->
        @if(session('error'))
            <div class="alert flex rounded-lg border border-error px-4 py-4 text-error sm:px-5 mb-5">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                          d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                          clip-rule="evenodd"/>
                </svg>
                <span>&nbsp;{{ session('error') }}</span>
            </div>
        @endif

        <!-- Main Content -->
        <div class="card pb-4" x-data="appointmentsManagement()">
            <div class="px-4 sm:px-5">
                <!-- Header with View Toggle -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mt-4 mb-5 space-y-4 sm:space-y-0">
                    <div class="flex items-center space-x-4">
                        <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100">Your Appointments</h3>
                        <span class="text-xs text-slate-500 dark:text-navy-300">{{ $appointments->total() }} total</span>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <!-- View Toggle -->
                        <div class="btn-group">
                            <button @click="currentView = 'table'"
                                    :class="currentView === 'table' ? 'btn bg-primary text-white' : 'btn border border-slate-300 text-slate-700 hover:bg-slate-150'"
                                    class="rounded-l-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                                </svg>
                                Table
                            </button>
                            <a href="{{ route('dietitian.calendar.index') }}"
                               class="btn border border-slate-300 text-slate-700 hover:bg-slate-150 rounded-r-lg border-l-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Calendar
                            </a>
                        </div>
                        
                        <!-- Create Button -->
                        <a href="{{ route('dietitian.appointments.create') }}"
                           class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 mr-2" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 4v16m8-8H4"/>
                            </svg>
                            New Appointment
                        </a>
                    </div>
                </div>

                <!-- Filters -->
                <div class="mb-6 p-4 rounded-lg bg-slate-50 dark:bg-navy-600">
                    <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Status Filter -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-1">Status</label>
                            <select name="status" class="form-select w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700">
                                <option value="">All Statuses</option>
                                @foreach($statusOptions as $value => $label)
                                    <option value="{{ $value }}" {{ request('status') === $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Date From -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-1">From Date</label>
                            <input type="date" name="date_from" value="{{ request('date_from') }}"
                                   class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450">
                        </div>

                        <!-- Date To -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-1">To Date</label>
                            <input type="date" name="date_to" value="{{ request('date_to') }}"
                                   class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450">
                        </div>

                        <!-- Patient Search -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-1">Patient</label>
                            <input type="text" name="patient_search" value="{{ request('patient_search') }}"
                                   placeholder="Search patient name or email"
                                   class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450">
                        </div>

                        <!-- Filter Actions -->
                        <div class="sm:col-span-2 lg:col-span-4 flex justify-end space-x-3">
                            <a href="{{ route('dietitian.appointments.index') }}"
                               class="btn border border-slate-300 text-slate-700 hover:bg-slate-150 dark:border-navy-450 dark:text-navy-100">
                                Clear
                            </a>
                            <button type="submit"
                                    class="btn bg-slate-700 text-white hover:bg-slate-800 dark:bg-navy-500 dark:hover:bg-navy-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"/>
                                </svg>
                                Filter
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Appointments Table -->
                <div class="min-w-full overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                        <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                            <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">Patient</th>
                            <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">Date & Time</th>
                            <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">Type</th>
                            <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">Status</th>
                            <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">Notes</th>
                            <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100 text-right">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($appointments as $appointment)
                            <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500 hover:bg-slate-50 dark:hover:bg-navy-600/50">
                                <!-- Patient -->
                                <td class="whitespace-nowrap px-3 py-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex items-center justify-center size-8 rounded-full bg-primary/10 text-primary dark:bg-accent/10 dark:text-accent">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-medium text-slate-800 dark:text-navy-100">{{ $appointment->patient->user->name }}</p>
                                            <p class="text-xs text-slate-500 dark:text-navy-300">{{ $appointment->patient->user->email }}</p>
                                        </div>
                                    </div>
                                </td>

                                <!-- Date & Time -->
                                <td class="whitespace-nowrap px-3 py-4">
                                    <div>
                                        <p class="font-medium text-slate-800 dark:text-navy-100">{{ $appointment->formatted_date }}</p>
                                        <p class="text-sm text-slate-600 dark:text-navy-300">{{ $appointment->formatted_time_range }}</p>
                                    </div>
                                </td>

                                <!-- Type -->
                                <td class="whitespace-nowrap px-3 py-4">
                                    <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-medium"
                                          style="background-color: {{ $appointment->appointmentType->color }}20; color: {{ $appointment->appointmentType->color }}">
                                        {{ $appointment->appointmentType->name }}
                                    </span>
                                </td>

                                <!-- Status -->
                                <td class="whitespace-nowrap px-3 py-4">
                                    @switch($appointment->status)
                                        @case('scheduled')
                                            <span class="badge rounded-full bg-info/10 text-info dark:bg-info/10 dark:text-info">
                                                Scheduled
                                            </span>
                                            @break
                                        @case('completed')
                                            <span class="badge rounded-full bg-success/10 text-success dark:bg-success/10 dark:text-success">
                                                Completed
                                            </span>
                                            @break
                                        @case('canceled')
                                            <span class="badge rounded-full bg-error/10 text-error dark:bg-error/10 dark:text-error">
                                                Canceled
                                            </span>
                                            @break
                                        @case('no_show')
                                            <span class="badge rounded-full bg-warning/10 text-warning dark:bg-warning/10 dark:text-warning">
                                                No Show
                                            </span>
                                            @break
                                    @endswitch
                                </td>

                                <!-- Notes -->
                                <td class="px-3 py-4 max-w-xs">
                                    @if($appointment->notes)
                                        <p class="text-sm text-slate-600 dark:text-navy-300 truncate" title="{{ $appointment->notes }}">
                                            {{ $appointment->notes }}
                                        </p>
                                    @else
                                        <span class="text-xs text-slate-400 dark:text-navy-400">No notes</span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="whitespace-nowrap px-3 py-4 text-right">
                                    <div class="flex justify-end items-center space-x-2">
                                        <!-- View -->
                                        <a href="{{ route('dietitian.appointments.show', $appointment) }}"
                                           class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 text-slate-600"
                                           title="View Details">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>

                                        @if($appointment->can_be_rescheduled)
                                            <!-- Edit -->
                                            <a href="{{ route('dietitian.appointments.edit', $appointment) }}"
                                               class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 text-info"
                                               title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                        @endif

                                        @if($appointment->can_be_completed && $appointment->status === 'scheduled')
                                            <!-- Complete -->
                                            <button @click="quickComplete({{ $appointment->id }})"
                                                    class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 text-success"
                                                    title="Mark as Completed">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </button>
                                        @endif

                                        @if($appointment->can_be_canceled)
                                            <!-- Cancel -->
                                            <button @click="quickCancel({{ $appointment->id }})"
                                                    class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 text-error"
                                                    title="Cancel">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        @endif

                                        <!-- More Options Dropdown -->
                                        <div class="relative" x-data="{ open: false }">
                                            <button @click="open = !open"
                                                    class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 text-slate-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                                </svg>
                                            </button>
                                            
                                            <div x-show="open" @click.away="open = false"
                                                 x-transition:enter="transition ease-out duration-100"
                                                 x-transition:enter-start="transform opacity-0 scale-95"
                                                 x-transition:enter-end="transform opacity-100 scale-100"
                                                 x-transition:leave="transition ease-in duration-75"
                                                 x-transition:leave-start="transform opacity-100 scale-100"
                                                 x-transition:leave-end="transform opacity-0 scale-95"
                                                 class="absolute right-0 z-10 mt-2 w-48 rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 dark:bg-navy-700"
                                                 style="display: none;">
                                                
                                                @if($appointment->can_be_completed && $appointment->status === 'scheduled')
                                                    <button @click="markNoShow({{ $appointment->id }}); open = false"
                                                            class="block w-full px-4 py-2 text-left text-sm text-slate-700 hover:bg-slate-100 dark:text-navy-100 dark:hover:bg-navy-600">
                                                        Mark as No Show
                                                    </button>
                                                @endif
                                                
                                                <form method="POST" action="{{ route('dietitian.appointments.destroy', $appointment) }}"
                                                      class="block"
                                                      onsubmit="return confirm('Are you sure you want to delete this appointment?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="block w-full px-4 py-2 text-left text-sm text-error hover:bg-slate-100 dark:hover:bg-navy-600">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-3 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="flex items-center justify-center size-16 rounded-full bg-slate-100 dark:bg-navy-600 mb-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-8 text-slate-400 dark:text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100 mb-2">No appointments found</h3>
                                        <p class="text-slate-500 dark:text-navy-300 mb-4">
                                            @if(request()->hasAny(['status', 'date_from', 'date_to', 'patient_search']))
                                                Try adjusting your filters or
                                                <a href="{{ route('dietitian.appointments.index') }}" class="text-primary hover:text-primary-focus">clear all filters</a>
                                            @else
                                                Get started by creating your first appointment
                                            @endif
                                        </p>
                                        @if(!request()->hasAny(['status', 'date_from', 'date_to', 'patient_search']))
                                            <a href="{{ route('dietitian.appointments.create') }}"
                                               class="btn bg-primary font-medium text-white hover:bg-primary-focus">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                </svg>
                                                Create First Appointment
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($appointments->hasPages())
                    <div class="flex justify-between items-center px-4 py-4 sm:px-5">
                        <div class="text-xs+">
                            {{ $appointments->firstItem() }} - {{ $appointments->lastItem() }} of {{ $appointments->total() }} appointments
                        </div>
                        <div>
                            {{ $appointments->links('pagination.tailwind') }}
                        </div>
                    </div>
                @endif
            </div>

            <!-- Quick Complete Modal -->
            <template x-teleport="#x-teleport-target">
                <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
                     x-show="showCompleteModal" role="dialog" @keydown.window.escape="showCompleteModal = false">
                    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
                         @click="showCompleteModal = false" x-show="showCompleteModal"></div>
                    <div class="relative w-full max-w-lg flex flex-col overflow-hidden rounded-lg bg-white transition-all duration-300 dark:bg-navy-700"
                         x-show="showCompleteModal">
                        
                        <div class="flex justify-between items-center bg-slate-100 dark:bg-navy-800 px-4 py-3 border-b border-slate-200 dark:border-navy-600">
                            <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100">Complete Appointment</h3>
                            <button @click="showCompleteModal = false"
                                    class="btn size-8 rounded-full p-0 hover:bg-slate-300/20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        <div class="p-4">
                            <form @submit.prevent="completeAppointment()">
                                <label class="block">
                                    <span class="text-slate-600 dark:text-navy-100 font-medium">Session Notes (Optional)</span>
                                    <textarea x-model="completeNotes"
                                              :disabled="isLoading"
                                              class="form-textarea mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent disabled:opacity-50"
                                              rows="4"
                                              placeholder="Add any notes about this session..."></textarea>
                                </label>

                                <div class="flex justify-end space-x-3 pt-4">
                                    <button type="button" @click="showCompleteModal = false"
                                            :disabled="isLoading"
                                            class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 disabled:opacity-50">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                            :disabled="isLoading"
                                            class="btn min-w-[7rem] rounded-full bg-success font-medium text-white hover:bg-success-focus disabled:opacity-50">
                                        <template x-if="!isLoading">
                                            <span>Complete</span>
                                        </template>
                                        <template x-if="isLoading">
                                            <div class="flex items-center">
                                                <svg class="animate-spin size-4 mr-2" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                                Completing...
                                            </div>
                                        </template>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </template>

            <!-- Quick Cancel Modal -->
            <template x-teleport="#x-teleport-target">
                <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
                     x-show="showCancelModal" role="dialog" @keydown.window.escape="showCancelModal = false">
                    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
                         @click="showCancelModal = false" x-show="showCancelModal"></div>
                    <div class="relative w-full max-w-lg flex flex-col overflow-hidden rounded-lg bg-white transition-all duration-300 dark:bg-navy-700"
                         x-show="showCancelModal">
                        
                        <div class="flex justify-between items-center bg-slate-100 dark:bg-navy-800 px-4 py-3 border-b border-slate-200 dark:border-navy-600">
                            <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100">Cancel Appointment</h3>
                            <button @click="showCancelModal = false"
                                    class="btn size-8 rounded-full p-0 hover:bg-slate-300/20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        <div class="p-4">
                            <form @submit.prevent="cancelAppointment()">
                                <label class="block">
                                    <span class="text-slate-600 dark:text-navy-100 font-medium">Cancellation Reason (Optional)</span>
                                    <textarea x-model="cancelReason"
                                              :disabled="isLoading"
                                              class="form-textarea mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent disabled:opacity-50"
                                              rows="3"
                                              placeholder="Reason for cancellation..."></textarea>
                                </label>

                                <div class="flex justify-end space-x-3 pt-4">
                                    <button type="button" @click="showCancelModal = false"
                                            :disabled="isLoading"
                                            class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 disabled:opacity-50">
                                        Keep Appointment
                                    </button>
                                    <button type="submit"
                                            :disabled="isLoading"
                                            class="btn min-w-[7rem] rounded-full bg-error font-medium text-white hover:bg-error-focus disabled:opacity-50">
                                        <template x-if="!isLoading">
                                            <span>Cancel Appointment</span>
                                        </template>
                                        <template x-if="isLoading">
                                            <div class="flex items-center">
                                                <svg class="animate-spin size-4 mr-2" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                                Canceling...
                                            </div>
                                        </template>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </template>

            <!-- No Show Modal -->
            <template x-teleport="#x-teleport-target">
                <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
                     x-show="showNoShowModal" role="dialog" @keydown.window.escape="showNoShowModal = false">
                    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
                         @click="showNoShowModal = false" x-show="showNoShowModal"></div>
                    <div class="relative w-full max-w-lg flex flex-col overflow-hidden rounded-lg bg-white transition-all duration-300 dark:bg-navy-700"
                         x-show="showNoShowModal">
                        
                        <div class="flex justify-between items-center bg-slate-100 dark:bg-navy-800 px-4 py-3 border-b border-slate-200 dark:border-navy-600">
                            <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100">Mark as No Show</h3>
                            <button @click="showNoShowModal = false"
                                    class="btn size-8 rounded-full p-0 hover:bg-slate-300/20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        <div class="p-4">
                            <p class="text-sm text-slate-600 dark:text-navy-300 mb-4">
                                Mark this appointment as a no-show. This action can be undone later if needed.
                            </p>
                            
                            <form @submit.prevent="markAsNoShow()">
                                <label class="block">
                                    <span class="text-slate-600 dark:text-navy-100 font-medium">Notes (Optional)</span>
                                    <textarea x-model="noShowNotes"
                                              :disabled="isLoading"
                                              class="form-textarea mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent disabled:opacity-50"
                                              rows="3"
                                              placeholder="Additional notes..."></textarea>
                                </label>

                                <div class="flex justify-end space-x-3 pt-4">
                                    <button type="button" @click="showNoShowModal = false"
                                            :disabled="isLoading"
                                            class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 disabled:opacity-50">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                            :disabled="isLoading"
                                            class="btn min-w-[7rem] rounded-full bg-warning font-medium text-white hover:bg-warning-focus disabled:opacity-50">
                                        <template x-if="!isLoading">
                                            <span>Mark No Show</span>
                                        </template>
                                        <template x-if="isLoading">
                                            <div class="flex items-center">
                                                <svg class="animate-spin size-4 mr-2" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                                Updating...
                                            </div>
                                        </template>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </main>

    @slot('script')
        <script>
            function appointmentsManagement() {
                return {
                    // View state
                    currentView: 'table',
                    
                    // Modal states
                    showCompleteModal: false,
                    showCancelModal: false,
                    showNoShowModal: false,
                    
                    // Loading state
                    isLoading: false,
                    
                    // Action data
                    currentAppointmentId: null,
                    completeNotes: '',
                    cancelReason: '',
                    noShowNotes: '',

                    // Show success message
                    showSuccess(message) {
                        const alert = document.createElement('div');
                        alert.className = 'alert flex rounded-lg border border-success px-4 py-4 text-success sm:px-5 mb-5 fixed top-4 right-4 z-50 max-w-md';
                        alert.innerHTML = `
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>${message}</span>
                        `;
                        document.body.appendChild(alert);
                        
                        setTimeout(() => {
                            if (alert.parentNode) {
                                alert.parentNode.removeChild(alert);
                            }
                        }, 3000);
                    },

                    // Quick complete
                    quickComplete(appointmentId) {
                        this.currentAppointmentId = appointmentId;
                        this.completeNotes = '';
                        this.showCompleteModal = true;
                    },

                    // Complete appointment
                    async completeAppointment() {
                        if (this.isLoading) return;

                        this.isLoading = true;

                        try {
                            const formData = new FormData();
                            formData.append('dietitian_notes', this.completeNotes);
                            formData.append('_token', '{{ csrf_token() }}');
                            formData.append('_method', 'PATCH');

                            const response = await fetch(`{{ route("dietitian.appointments.index") }}/${this.currentAppointmentId}/complete`, {
                                method: 'POST',
                                body: formData
                            });

                            if (response.ok) {
                                this.showCompleteModal = false;
                                this.showSuccess('Appointment marked as completed!');
                                setTimeout(() => window.location.reload(), 1000);
                            } else {
                                throw new Error('Failed to complete appointment');
                            }
                        } catch (error) {
                            console.error('Error:', error);
                            alert('Error completing appointment. Please try again.');
                        } finally {
                            this.isLoading = false;
                        }
                    },

                    // Quick cancel
                    quickCancel(appointmentId) {
                        this.currentAppointmentId = appointmentId;
                        this.cancelReason = '';
                        this.showCancelModal = true;
                    },

                    // Cancel appointment
                    async cancelAppointment() {
                        if (this.isLoading) return;

                        this.isLoading = true;

                        try {
                            const formData = new FormData();
                            formData.append('cancellation_reason', this.cancelReason);
                            formData.append('_token', '{{ csrf_token() }}');
                            formData.append('_method', 'PATCH');

                            const response = await fetch(`{{ route("dietitian.appointments.index") }}/${this.currentAppointmentId}/cancel`, {
                                method: 'POST',
                                body: formData
                            });

                            if (response.ok) {
                                this.showCancelModal = false;
                                this.showSuccess('Appointment canceled successfully!');
                                setTimeout(() => window.location.reload(), 1000);
                            } else {
                                throw new Error('Failed to cancel appointment');
                            }
                        } catch (error) {
                            console.error('Error:', error);
                            alert('Error canceling appointment. Please try again.');
                        } finally {
                            this.isLoading = false;
                        }
                    },

                    // Mark no show
                    markNoShow(appointmentId) {
                        this.currentAppointmentId = appointmentId;
                        this.noShowNotes = '';
                        this.showNoShowModal = true;
                    },

                    // Mark as no show
                    async markAsNoShow() {
                        if (this.isLoading) return;

                        this.isLoading = true;

                        try {
                            const formData = new FormData();
                            formData.append('dietitian_notes', this.noShowNotes);
                            formData.append('_token', '{{ csrf_token() }}');
                            formData.append('_method', 'PATCH');

                            const response = await fetch(`{{ route("dietitian.appointments.index") }}/${this.currentAppointmentId}/no-show`, {
                                method: 'POST',
                                body: formData
                            });

                            if (response.ok) {
                                this.showNoShowModal = false;
                                this.showSuccess('Appointment marked as no-show!');
                                setTimeout(() => window.location.reload(), 1000);
                            } else {
                                throw new Error('Failed to mark as no-show');
                            }
                        } catch (error) {
                            console.error('Error:', error);
                            alert('Error updating appointment. Please try again.');
                        } finally {
                            this.isLoading = false;
                        }
                    }
                };
            }
        </script>
    @endslot
</x-app-layout>