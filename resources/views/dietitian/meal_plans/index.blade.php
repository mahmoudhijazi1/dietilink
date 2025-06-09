<x-app-layout title="Meal Plans" is-header-blur="true">
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="flex items-center justify-between mb-5 mt-5">
            <h1 class="text-xl font-medium text-slate-700 line-clamp-1 dark:text-navy-100">
                Meal Plans
            </h1>

            <a href="{{ route('dietitian.meal-plans.create') }}"
                class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Add Meal Plan</span>
            </a>
        </div>

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

        <div class="card pb-4">
            <div class="px-4 sm:px-5">
                <div class="min-w-full overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                                    Name</th>
                                <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                                    Patient</th>
                                <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                                    Created At</th>
                                <th class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100">
                                    Status</th>
                                <th
                                    class="whitespace-nowrap px-3 py-3 font-semibold text-slate-800 dark:text-navy-100 text-right">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mealPlans as $mealPlan)
                                <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                    <td class="whitespace-nowrap px-3 py-3">{{ $mealPlan->name }}</td>
                                    <td class="whitespace-nowrap px-3 py-3">{{ $mealPlan->patient->user->name }}</td>
                                    <td class="whitespace-nowrap px-3 py-3">{{ $mealPlan->created_at->format('Y-m-d') }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-3">{{ $mealPlan->status }}</td>
                                    <td class="whitespace-nowrap px-3 py-3 text-right">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('dietitian.meal-plans.show', $mealPlan) }}"
                                                class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25"
                                                title="View">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('dietitian.meal-plans.edit', $mealPlan) }}"
                                                class="btn size-8 rounded-full p-0 hover:bg-slate-300/20" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <form method="POST"
                                                action="{{ route('dietitian.meal-plans.destroy', $mealPlan) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn size-8 rounded-full p-0 hover:bg-slate-300/20" title="Delete"
                                                    onclick="return confirm('Are you sure you want to delete this meal plan?')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-3 py-8 text-center text-slate-500 dark:text-navy-300">
                                        No meal plans found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-between items-center px-4 py-4 sm:px-5">
                    <div class="text-xs+">
                        {{ $mealPlans->firstItem() }} - {{ $mealPlans->lastItem() }} of {{ $mealPlans->total() }} plans
                    </div>
                    <div>
                        {{ $mealPlans->links('pagination.tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>