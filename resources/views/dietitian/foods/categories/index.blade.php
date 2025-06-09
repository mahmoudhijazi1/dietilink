<?php /** @var \Illuminate\Pagination\LengthAwarePaginator $categories */ ?>

<x-app-layout title="Food Categories" is-header-blur="true">
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="flex items-center justify-between mt-5 mb-5">
            <h1 class="text-xl font-medium text-slate-700 line-clamp-1 dark:text-navy-100">
                Food Categories
            </h1>
            <div class="flex space-x-2">
                <a href="{{ route('dietitian.foods.categories.create') }}"
                    class="btn bg-primary text-white hover:bg-primary-focus focus:bg-primary-focus dark:bg-accent dark:hover:bg-accent-focus">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Add Category</span>
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert flex rounded-lg border border-success px-4 py-4 text-success sm:px-5 mb-5">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 20 20"
                    stroke="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <span>&nbsp;{{ session('success') }}</span>
            </div>
        @endif

        <div class="card px-4 py-6 sm:px-5">
            <div class="overflow-x-auto">
                <table class="table w-full text-left">
                    <thead>
                        <tr class="border-b border-slate-200 dark:border-navy-500">
                            <th class="whitespace-nowrap px-3 py-3 text-slate-800 font-semibold dark:text-navy-100">
                                Name
                            </th>
                            <th class="whitespace-nowrap px-3 py-3 text-right text-slate-800 font-semibold dark:text-navy-100">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr class="border-b border-slate-200 dark:border-navy-500">
                                <td class="whitespace-nowrap px-3 py-3">
                                    {{ $category->name }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-3 text-right">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('dietitian.foods.categories.edit', $category) }}"
                                            class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 dark:hover:bg-navy-300/20"
                                            title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form method="POST" action="{{ route('dietitian.foods.categories.destroy', $category) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn size-8 rounded-full p-0 hover:bg-error/10 text-error dark:hover:bg-error/15"
                                                title="Delete" onclick="return confirm('Delete this category?')">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-3 py-6 text-center text-slate-500 dark:text-navy-300">
                                    No categories found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($categories->hasPages())
                <div class="mt-4">
                    {{ $categories->links('pagination.tailwind') }}
                </div>
            @endif
        </div>
    </main>
</x-app-layout>
