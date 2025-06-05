<?php
// resources/views/dietitian/foods/items/edit.blade.php
?>

<x-app-layout title="Edit Food Item" is-header-blur="true">
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="flex items-center space-x-4 py-5 lg:py-6">
            <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
                Edit Food Item
            </h2>
            <div class="hidden h-full py-1 sm:flex">
                <div class="h-full w-px bg-slate-300 dark:bg-navy-600"></div>
            </div>
            <ul class="hidden flex-wrap items-center space-x-2 sm:flex">
                <li class="flex items-center space-x-2">
                    <a class="text-primary transition-colors hover:text-primary-focus dark:text-accent-light dark:hover:text-accent"
                       href="{{ route('dietitian.dashboard') }}">Dashboard</a>
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </li>
                <li class="flex items-center space-x-2">
                    <a class="text-primary transition-colors hover:text-primary-focus dark:text-accent-light dark:hover:text-accent"
                       href="{{ route('dietitian.foods.items.index') }}">Food Items</a>
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </li>
                <li>Edit</li>
            </ul>
        </div>

        <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
            <div class="col-span-12 lg:col-span-8">
                <div class="card">
                    <div
                        class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                        <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                            Update Food Item
                        </h2>
                        <div class="flex justify-center space-x-2">
                            <a href="{{ route('dietitian.foods.items.index') }}"
                               class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-700 hover:bg-slate-150 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-500">
                                Cancel
                            </a>
                        </div>
                    </div>

                    <div class="p-4 sm:p-5">
                        @if ($errors->any())
                            <div class="alert flex rounded-lg border border-error px-4 py-4 text-error sm:px-5 mb-5">
                                <ul class="list-disc list-inside text-sm">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('dietitian.foods.items.update', $foodItem->id) }}" method="POST" class="space-y-5">
                            @csrf
                            @method('PUT')

                            <label class="block">
                                <span class="font-medium text-slate-600 dark:text-navy-100">Item Name</span>
                                <input name="name" type="text" value="{{ old('name', $foodItem->name) }}"
                                       class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                       required>
                            </label>

                            <label class="block">
                                <span class="font-medium text-slate-600 dark:text-navy-100">Unit</span>
                                <select name="unit"
                                        class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 dark:border-navy-450 dark:bg-navy-700 dark:text-white"
                                        required>
                                    <option value="" disabled>Select unit</option>
                                    <option value="gram" {{ $foodItem->unit === 'gram' ? 'selected' : '' }}>Gram</option>
                                    <option value="ml" {{ $foodItem->unit === 'ml' ? 'selected' : '' }}>ml</option>
                                    <option value="piece" {{ $foodItem->unit === 'piece' ? 'selected' : '' }}>Piece</option>
                                    <option value="cup" {{ $foodItem->unit === 'cup' ? 'selected' : '' }}>Cup</option>
                                </select>
                            </label>

                            <label class="block">
                                <span class="font-medium text-slate-600 dark:text-navy-100">Category</span>
                                <select name="food_category_id"
                                        class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 dark:border-navy-450 dark:bg-navy-700 dark:text-white"
                                        required>
                                    <option value="" disabled>Select category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $foodItem->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </label>

                            <div class="flex justify-end space-x-2 pt-4">
                                <a href="{{ route('dietitian.foods.items.index') }}"
                                   class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-700 hover:bg-slate-150 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-500">
                                    Cancel
                                </a>
                                <button type="submit"
                                        class="btn min-w-[7rem] rounded-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus dark:bg-accent dark:hover:bg-accent-focus">
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-span-12 lg:col-span-4">
                <div class="card">
                    <div
                        class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                        <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                            Editing Tips
                        </h2>
                    </div>
                    <div class="p-4 sm:p-5 text-sm text-slate-600 dark:text-navy-300 space-y-2">
                        <p>Changing a food item affects all future meal options using it.</p>
                        <p>Ensure unit consistency to prevent confusion in patient plans.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>
