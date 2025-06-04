<x-app-layout title="Patients" is-header-blur="true">
    <!-- Main Content Wrapper -->
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="flex items-center justify-between mb-5 mt-5">
            <h1 class="text-xl font-medium text-slate-700 line-clamp-1 dark:text-navy-100">
                Patients
            </h1>
            <div class="flex space-x-2">
                <a href="{{ route('dietitian.patients.invite') }}"
                    class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Invite Patient</span>
                </a>
            </div>
        </div>

        <!-- Flash Message -->
        @if(session('success'))
            <div class="alert flex rounded-lg border border-success px-4 py-4 text-success sm:px-5 mb-5">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Main Content -->
        <div class="grid grid-cols-1 gap-4 sm:gap-5 lg:gap-6">
            <div class="card pb-4">
                <div class="my-3 flex h-8 items-center justify-between px-4 sm:px-5">
                    <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                        Patient List
                    </h2>
                    <div class="flex">
                        <div class="relative mr-4">
                            <form action="{{ route('dietitian.patients.index') }}" method="GET">
                                <div class="relative">
                                    <input id="patientSearch" name="search"
                                        class="form-input peer h-9 w-full rounded-full border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Search patients..." type="text" value="{{ $search ?? '' }}" />
                                    <span
                                        class="absolute left-0 top-0 flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </span>
                                </div>
                            </form>
                        </div>
                        <div x-data="usePopper({ placement: 'bottom-end', offset: 4 })"
                            @click.outside="if(isShowPopper) isShowPopper = false" class="inline-flex">
                            <button x-ref="popperRef" @click="isShowPopper = !isShowPopper"
                                class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                </svg>
                            </button>

                            <div x-ref="popperRoot" class="popper-root" :class="isShowPopper && 'show'">
                                <div
                                    class="popper-box rounded-md border border-slate-150 bg-white py-1.5 font-inter dark:border-navy-500 dark:bg-navy-700">
                                    <ul>
                                        <li>
                                            <a href="{{ route('dietitian.patients.invite') }}"
                                                class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
                                                <span class="mr-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M12 4v16m8-8H4" />
                                                    </svg>
                                                </span>
                                                Invite Patient
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#"
                                                class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
                                                <span class="mr-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                    </svg>
                                                </span>
                                                Export Patients
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Patients Table -->
                <div class="px-4 sm:px-5">
                    <div class="min-w-full overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                    <th
                                        class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                                        Patient
                                    </th>
                                    <th
                                        class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                                        Email
                                    </th>
                                    <th
                                        class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                                        Phone
                                    </th>
                                    <th
                                        class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                                        Status
                                    </th>
                                    <th
                                        class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                                        Last Progress
                                    </th>
                                    <th
                                        class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                                        Current Weight
                                    </th>
                                    <th
                                        class="whitespace-nowrap px-3 py-3 font-semibold text-right text-slate-800 dark:text-navy-100">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($patients as $patient)
                                    <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                        <td class="whitespace-nowrap px-3 py-3">
                                            <div class="flex items-center space-x-3">
                                                <div class="avatar size-9">
                                                    <div class="is-initial rounded-full bg-info text-white">
                                                        {{ substr($patient->user->name, 0, 1) }}
                                                    </div>
                                                </div>
                                                <div>
                                                    <p class="font-medium text-slate-700 dark:text-navy-100">
                                                        {{ $patient->user->name }}
                                                    </p>
                                                    <p class="text-xs text-slate-400 dark:text-navy-300">
                                                        @if($patient->gender)
                                                            {{ ucfirst($patient->gender) }}
                                                        @else
                                                            Not specified
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-3">
                                            <p>{{ $patient->user->email }}</p>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-3">
                                            <p>{{ $patient->phone ?? 'Not provided' }}</p>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-3">
                                            @if($patient->user->status === 'active')
                                                <div class="badge bg-success/10 text-success dark:bg-success/15">Active</div>
                                            @elseif($patient->user->status === 'invited')
                                                <div class="badge bg-warning/10 text-warning dark:bg-warning/15">Invited</div>
                                            @else
                                                <div class="badge bg-error/10 text-error dark:bg-error/15">
                                                    {{ ucfirst($patient->user->status) }}</div>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-3">
                                            @php
                                                $lastProgress = \App\Models\ProgressEntry::where('patient_id', $patient->id)->latest()->first();
                                            @endphp
                                            @if($lastProgress)
                                                {{ $lastProgress->measurement_date->format('M d, Y') }}
                                            @else
                                                <span class="text-slate-400 dark:text-navy-300">No progress yet</span>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-3">
                                            @if($lastProgress)
                                                {{ $lastProgress->weight }} kg
                                            @elseif($patient->initial_weight)
                                                {{ $patient->initial_weight }} kg (initial)
                                            @else
                                                <span class="text-slate-400 dark:text-navy-300">Not recorded</span>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-3 text-right">
                                            <div class="flex justify-end space-x-2">
                                                <a href="{{ route('dietitian.patients.show', $patient->id) }}"
                                                    class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25"
                                                    title="View">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>
                                                <a href="{{ route('dietitian.patients.edit', $patient->id) }}"
                                                    class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25"
                                                    title="Edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                                <button onclick="confirmDelete({{ $patient->id }})"
                                                    class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25"
                                                    title="Delete">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-3 py-8 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-16 text-slate-400"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                                </svg>
                                                <p class="mt-2 text-slate-500 dark:text-navy-300">No patients found</p>
                                                <a href="{{ route('dietitian.patients.invite') }}"
                                                    class="btn mt-4 bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                                    Invite Your First Patient
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div
                        class="flex flex-col justify-between space-y-4 px-4 py-4 sm:flex-row sm:items-center sm:space-y-0 sm:px-5">
                        <div class="text-xs+">
                            {{ $patients->firstItem() }} - {{ $patients->lastItem() }} of {{ $patients->total() }}
                            patients
                        </div>
                        <div>
                            {{ $patients->links('pagination.tailwind') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div id="deleteModal"
            class="fixed inset-0 z-[100] hidden items-center justify-center bg-slate-900/60 backdrop-blur">
            <div class="card w-full max-w-lg p-4 sm:p-5">
                <div class="mt-4 text-center sm:mt-5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-16 mx-auto text-error" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <h3 class="mt-4 text-xl font-medium text-slate-700 dark:text-navy-100">
                        Delete Patient
                    </h3>
                    <p class="mt-2 text-slate-500 dark:text-navy-300">
                        Are you sure you want to delete this patient? All data associated with this patient will be
                        permanently removed. This action cannot be undone.
                    </p>
                </div>
                <div class="flex justify-center space-x-3 pt-4">
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="hideDeleteModal()"
                            class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                            Cancel
                        </button>
                        <button type="submit"
                            class="btn min-w-[7rem] rounded-full bg-error font-medium text-white hover:bg-error-focus focus:bg-error-focus active:bg-error-focus/90">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    @push('scripts')
        <script>
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
            document.getElementById('deleteModal').addEventListener('click', function (e) {
                if (e.target === this) {
                    hideDeleteModal();
                }
            });

            // Auto-submit search form on input
            document.addEventListener('DOMContentLoaded', function () {
                const searchInput = document.getElementById('patientSearch');

                if (searchInput) {
                    let typingTimer;
                    const doneTypingInterval = 500; // ms

                    searchInput.addEventListener('input', function () {
                        clearTimeout(typingTimer);
                        if (this.value) {
                            typingTimer = setTimeout(() => {
                                this.closest('form').submit();
                            }, doneTypingInterval);
                        }
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>