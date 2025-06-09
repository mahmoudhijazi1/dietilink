<x-app-layout title="Create a New Meal Plan" is-header-blur="true">
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <!-- Breadcrumb -->
        <div class="flex items-center space-x-4 py-5 lg:py-6">
            <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">Create a New Meal Plan</h2>
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
                <li>Add</li>
            </ul>
        </div>

        <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
            <div class="col-span-12 lg:col-span-8">
                <div class="card">
                    <div class="flex items-center justify-between border-b border-slate-200 px-4 py-4 dark:border-navy-500 sm:px-5">
                        <h2 class="text-lg font-medium text-slate-700 dark:text-navy-100">Meal Plan Information</h2>
                        <a href="{{ route('dietitian.meal-plans.index') }}"
                            class="btn rounded-full border border-slate-300 font-medium text-slate-700 hover:bg-slate-150 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-500">
                            Cancel
                        </a>
                    </div>

                    <div class="p-4 sm:p-5" x-data="mealPlanBuilder()">
                        <form method="POST" action="{{ route('dietitian.meal-plans.store') }}">
                            @csrf

                            <!-- Basic Info -->
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <label class="block">
                                    <span class="font-medium text-slate-600 dark:text-navy-100">Meal Plan Name</span>
                                    <input name="name" type="text"
                                        class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 dark:border-navy-450 dark:bg-navy-700"
                                        required placeholder="e.g. Weekly Plan">
                                </label>
                                <label class="block">
                                    <span class="font-medium text-slate-600 dark:text-navy-100">Patient</span>
                                    <select name="patient_id" required
                                        class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 dark:border-navy-450 dark:bg-navy-700">
                                        <option value="" disabled selected>Select patient</option>
                                        @foreach ($patients as $patient)
                                            <option value="{{ $patient->id }}">
                                                {{ $patient->user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </label>
                            </div>

                            <label class="block mt-4">
                                <span class="font-medium text-slate-600 dark:text-navy-100">Notes</span>
                                <textarea name="notes" rows="3"
                                    class="form-textarea mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 dark:border-navy-450 dark:bg-navy-700"></textarea>
                            </label>

                            <!-- Meal Groups -->
                            <div class="mt-6 space-y-6">
                                <template x-for="(mealType, typeIndex) in mealTypes" :key="typeIndex">
                                    <div class="rounded-lg border border-slate-300 dark:border-navy-500 bg-slate-50 dark:bg-navy-800 overflow-hidden">
                                        <!-- Meal Type Header -->
                                        <div class="flex items-center justify-between bg-slate-100 dark:bg-navy-700 px-4 py-3 border-b border-slate-200 dark:border-navy-600">
                                            <div class="flex items-center space-x-3">
                                                <div class="flex items-center justify-center size-8 rounded-full bg-primary text-white text-sm font-medium">
                                                    <span x-text="typeIndex + 1"></span>
                                                </div>
                                                <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100" x-text="mealType.name"></h3>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <span class="text-sm text-slate-500 dark:text-navy-300" x-text="mealType.meals.length + ' meal(s)'"></span>
                                                <button type="button" @click="addMealToType(typeIndex)"
                                                    class="btn size-8 rounded-full bg-primary text-white text-sm hover:bg-primary-focus">+</button>
                                            </div>
                                        </div>

                                        <!-- Meals in this type -->
                                        <div class="p-4 space-y-4">
                                            <template x-for="(meal, mealIndex) in mealType.meals" :key="mealIndex">
                                                <div class="rounded-lg border border-slate-200 dark:border-navy-600 bg-white dark:bg-navy-700 p-4">
                                                    <div class="flex items-center justify-between mb-4">
                                                        <h4 class="font-medium text-slate-700 dark:text-navy-100" x-text="'Meal Option ' + (mealIndex + 1)"></h4>
                                                        <button type="button" @click="removeMealFromType(typeIndex, mealIndex)"
                                                            class="btn size-6 rounded-full bg-error text-white text-xs hover:bg-error-focus">×</button>
                                                    </div>

                                                    <!-- Hidden meal type input -->
                                                    <input type="hidden" :name="'meals[' + getMealIndex(typeIndex, mealIndex) + '][type]'" :value="mealType.type">

                                                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                                        <label class="block">
                                                            <span class="font-medium text-slate-600 dark:text-navy-100">Title</span>
                                                            <input type="text" x-model="meal.title" :name="'meals[' + getMealIndex(typeIndex, mealIndex) + '][title]'"
                                                                class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 dark:border-navy-450 dark:bg-navy-700" 
                                                                placeholder="e.g. Option A">
                                                        </label>
                                                        <label class="block">
                                                            <span class="font-medium text-slate-600 dark:text-navy-100">Description</span>
                                                            <input type="text" x-model="meal.description" :name="'meals[' + getMealIndex(typeIndex, mealIndex) + '][description]'"
                                                                class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 dark:border-navy-450 dark:bg-navy-700">
                                                        </label>
                                                    </div>

                                                    <label class="block mt-4">
                                                        <span class="font-medium text-slate-600 dark:text-navy-100">Note</span>
                                                        <textarea x-model="meal.note" :name="'meals[' + getMealIndex(typeIndex, mealIndex) + '][note]'"
                                                            class="form-textarea mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 dark:border-navy-450 dark:bg-navy-700" 
                                                            rows="2"></textarea>
                                                    </label>

                                                    <!-- Food Items Section -->
                                                    <div class="mt-4">
                                                        <h5 class="font-medium text-slate-600 dark:text-navy-100 mb-3">Food Items</h5>
                                                        <template x-for="(item, itemIndex) in meal.items" :key="itemIndex">
                                                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3 items-end mt-3 p-3 rounded-lg bg-slate-50 dark:bg-navy-600 border border-slate-200 dark:border-navy-500">
                                                                <label class="block">
                                                                    <span class="text-sm font-medium text-slate-600 dark:text-navy-100">Food Item</span>
                                                                    <select x-model="item.food_item_id" :name="'meals[' + getMealIndex(typeIndex, mealIndex) + '][items][' + itemIndex + '][food_item_id]'"
                                                                        class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 dark:border-navy-450 dark:bg-navy-700">
                                                                        <option value="">Select Food Item</option>
                                                                        @foreach ($foodItems as $foodItem)
                                                                            <option value="{{ $foodItem->id }}">{{ $foodItem->name }} ({{ $foodItem->unit }})</option>
                                                                        @endforeach
                                                                    </select>
                                                                </label>
                                                                <label class="block">
                                                                    <span class="text-sm font-medium text-slate-600 dark:text-navy-100">Portion Size</span>
                                                                    <input type="text" x-model="item.portion_size"
                                                                        :name="'meals[' + getMealIndex(typeIndex, mealIndex) + '][items][' + itemIndex + '][portion_size]'"
                                                                        class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 dark:border-navy-450 dark:bg-navy-700" 
                                                                        placeholder="e.g. 100g">
                                                                </label>
                                                                <div class="flex items-end space-x-2">
                                                                    <label class="block flex-1">
                                                                        <span class="text-sm font-medium text-slate-600 dark:text-navy-100">Notes</span>
                                                                        <input type="text" x-model="item.notes"
                                                                            :name="'meals[' + getMealIndex(typeIndex, mealIndex) + '][items][' + itemIndex + '][notes]'"
                                                                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 dark:border-navy-450 dark:bg-navy-700" 
                                                                            placeholder="Notes">
                                                                    </label>
                                                                    <button type="button" @click="removeItemFromMeal(typeIndex, mealIndex, itemIndex)"
                                                                        class="btn size-9 rounded-full bg-error text-white hover:bg-error-focus mb-1.5">−</button>
                                                                </div>
                                                            </div>
                                                        </template>

                                                        <button type="button" @click="addItemToMeal(typeIndex, mealIndex)"
                                                            class="mt-3 text-sm font-medium text-primary hover:text-primary-focus dark:text-accent dark:hover:text-accent">+ Add Food Item</button>
                                                    </div>
                                                </div>
                                            </template>

                                            <!-- Add meal button when no meals exist -->
                                            <div x-show="mealType.meals.length === 0" class="text-center py-8">
                                                <p class="text-slate-500 dark:text-navy-300 mb-3">No meals added for <span x-text="mealType.name"></span></p>
                                                <button type="button" @click="addMealToType(typeIndex)"
                                                    class="btn rounded-full border border-primary text-primary hover:bg-primary/10 dark:border-accent dark:text-accent dark:hover:bg-accent/10">
                                                    + Add &nbsp; <span x-text="mealType.name"></span>&nbsp; Meal
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <!-- Submit -->
                            <div class="pt-6 text-right">
                                <button type="submit"
                                    class="btn bg-primary font-medium text-white hover:bg-primary-focus dark:bg-accent dark:hover:bg-accent-focus">
                                    Save Meal Plan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tips Card -->
            <div class="col-span-12 lg:col-span-4">
                <div class="card">
                    <div class="border-b border-slate-200 px-4 py-4 dark:border-navy-500 sm:px-5">
                        <h2 class="text-lg font-medium text-slate-700 dark:text-navy-100">Tips</h2>
                    </div>
                    <div class="p-4 sm:p-5 text-sm text-slate-600 dark:text-navy-300 space-y-2">
                        <p><strong class="font-medium">Use the <em>Meal Type</em></strong> to categorize meals (e.g., Breakfast, Dinner).</p>
                        <p>Each meal can have multiple food options to increase variety.</p>
                        <p>Ensure each portion is realistic and easily measurable.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Alpine.js Component Script -->
    <script>
        function mealPlanBuilder() {
            return {
                mealTypes: [
                    { name: 'Breakfast', type: 'breakfast', meals: [] },
                    { name: 'Lunch', type: 'lunch', meals: [] },
                    { name: 'Dinner', type: 'dinner', meals: [] },
                    { name: 'Snack 1', type: 'snack_1', meals: [] },
                    { name: 'Snack 2', type: 'snack_2', meals: [] }
                ],

                addMealToType(typeIndex) {
                    this.mealTypes[typeIndex].meals.push({
                        title: '', 
                        description: '', 
                        note: '', 
                        items: []
                    });
                },

                removeMealFromType(typeIndex, mealIndex) {
                    this.mealTypes[typeIndex].meals.splice(mealIndex, 1);
                },

                addItemToMeal(typeIndex, mealIndex) {
                    this.mealTypes[typeIndex].meals[mealIndex].items.push({
                        food_item_id: '', 
                        portion_size: '', 
                        notes: ''
                    });
                },

                removeItemFromMeal(typeIndex, mealIndex, itemIndex) {
                    this.mealTypes[typeIndex].meals[mealIndex].items.splice(itemIndex, 1);
                },

                getMealIndex(typeIndex, mealIndex) {
                    let index = 0;
                    for (let i = 0; i < typeIndex; i++) {
                        index += this.mealTypes[i].meals.length;
                    }
                    return index + mealIndex;
                }
            };
        }
    </script>
</x-app-layout>