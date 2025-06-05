<?php
// resources/views/dietitian/foods/items/index.blade.php
?>

<x-app-layout title="Food Items" is-header-blur="true">
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <!-- Header + Breadcrumbs -->
        <div class="flex items-center space-x-4 py-5 lg:py-6">
            <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
                Food Items
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
                <li>Food Items</li>
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
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Main Content -->
        <div class="card pb-4">
            <div class="px-4 sm:px-5">
                <div class="flex justify-between items-center mt-4 mb-5">
                    <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100">Manage Food Items</h3>
                    <a href="{{ route('dietitian.foods.items.create') }}"
                       class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5 mr-2" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 4v16m8-8H4"/>
                        </svg>
                        Add Food Item
                    </a>
                </div>

                <!-- Table -->
                <div class="min-w-full overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                        <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                            <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">Name</th>
                            <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">Category</th>
                            <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">Unit</th>
                            <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100 text-right">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($items as $item)
                            <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                <td class="whitespace-nowrap px-3 py-3">{{ $item->name }}</td>
                                <td class="whitespace-nowrap px-3 py-3">{{ $item->category->name }}</td>
                                <td class="whitespace-nowrap px-3 py-3">{{ ucfirst($item->unit) }}</td>
                                <td class="whitespace-nowrap px-3 py-3 text-right">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('dietitian.foods.items.edit', $item->id) }}"
                                           class="btn size-8 rounded-full p-0 hover:bg-slate-300/20">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <button onclick="confirmDelete(this)"
                                                class="btn size-8 rounded-full p-0 hover:bg-slate-300/20"
                                                title="Delete" data-id="{{ $item->id }}"
                                                data-action="{{ route('dietitian.foods.items.destroy', ['foodItem' => '__ID__']) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-3 py-8 text-center text-slate-500 dark:text-navy-300">
                                    No food items found.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="flex justify-between items-center px-4 py-4 sm:px-5">
                    <div class="text-xs+">
                        {{ $items->firstItem() }} - {{ $items->lastItem() }} of {{ $items->total() }} items
                    </div>
                    <div>
                        {{ $items->links('pagination.tailwind') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <div id="deleteModal"
             class="fixed inset-0 z-[100] hidden items-center justify-center bg-slate-900/60 backdrop-blur">
            <div class="card w-full max-w-lg p-4 sm:p-5">
                <div class="mt-4 text-center sm:mt-5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-16 mx-auto text-error" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <h3 class="mt-4 text-xl font-medium text-slate-700 dark:text-navy-100">Delete Item</h3>
                    <p class="mt-2 text-slate-500 dark:text-navy-300">
                        Are you sure you want to delete this food item? This action cannot be undone.
                    </p>
                </div>
                <div class="flex justify-center space-x-3 pt-4">
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="hideDeleteModal()"
                                class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-800 dark:text-navy-50">
                            Cancel
                        </button>
                        <button type="submit"
                                class="btn min-w-[7rem] rounded-full bg-error font-medium text-white">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    @slot('script')
        <script>
            function confirmDelete(button) {
                const id = button.getAttribute('data-id');
                const form = document.getElementById('deleteForm');
                form.action = button.getAttribute('data-action').replace('__ID__', id);

                document.getElementById('deleteModal').classList.remove('hidden');
                document.getElementById('deleteModal').classList.add('flex');

                form.addEventListener('submit', function () {
                    form.querySelector('button[type="submit"]').disabled = true;
                });
            }

            function hideDeleteModal() {
                document.getElementById('deleteModal').classList.add('hidden');
                document.getElementById('deleteModal').classList.remove('flex');
            }

            document.getElementById('deleteModal').addEventListener('click', function (e) {
                if (e.target === this) hideDeleteModal();
            });
        </script>
    @endslot
</x-app-layout>
