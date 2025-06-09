<x-app-layout title="Food Management" is-header-blur="true">
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <!-- Header + Breadcrumbs -->
        <div class="flex items-center space-x-4 py-5 lg:py-6">
            <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
                Food Management
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
                <li>Food Management</li>
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

        <!-- Main Content -->
        <div class="card pb-4" x-data="foodManagement()">
            <div class="px-4 sm:px-5">
                <div class="flex justify-between items-center mt-4 mb-5">
                    <div class="flex items-center space-x-4">
                        <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100">Food Items</h3>
                        <button @click="showCategoriesModal = true"
                                class="btn size-8 rounded-full p-0 bg-info/10 text-info hover:bg-info/20 dark:bg-info/10 dark:hover:bg-info/20"
                                title="Manage Categories">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </button>
                        <span class="text-xs text-slate-500 dark:text-navy-300">{{ $categories->count() }} categories</span>
                    </div>
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
                                <td class="whitespace-nowrap px-3 py-3">
                                    <span class="badge rounded-full bg-primary/10 text-primary dark:bg-accent/10 dark:text-accent">
                                        {{ $item->category->name }}
                                    </span>
                                </td>
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
                                        <button @click="confirmDeleteItem({{ $item->id }})"
                                                class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 text-error"
                                                title="Delete">
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

            <!-- Categories Management Modal -->
            <template x-teleport="#x-teleport-target">
                <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
                     x-show="showCategoriesModal" role="dialog" @keydown.window.escape="showCategoriesModal = false">
                    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
                         @click="showCategoriesModal = false" x-show="showCategoriesModal" x-transition:enter="ease-out"
                         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                         x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"></div>
                    <div class="relative w-full max-w-2xl flex flex-col overflow-hidden rounded-lg bg-white transition-all duration-300 dark:bg-navy-700"
                         x-show="showCategoriesModal" x-transition:enter="easy-out"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100" x-transition:leave="easy-in"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95">
                        
                        <!-- Modal Header -->
                        <div class="flex justify-between items-center bg-slate-100 dark:bg-navy-800 px-4 py-3 border-b border-slate-200 dark:border-navy-600">
                            <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                                Manage Categories
                            </h3>
                            <button @click="showCategoriesModal = false"
                                    class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Modal Body -->
                        <div class="flex-1 overflow-y-auto p-4">
                            <!-- Add New Category -->
                            <div class="mb-6 p-4 rounded-lg bg-slate-50 dark:bg-navy-600">
                                <h4 class="text-sm font-medium text-slate-700 dark:text-navy-100 mb-3">Add New Category</h4>
                                <form @submit.prevent="addCategory()">
                                    <div class="flex space-x-3">
                                        <input x-model="newCategoryName" type="text" 
                                               :disabled="isLoading"
                                               class="form-input flex-1 rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent disabled:opacity-50 disabled:cursor-not-allowed"
                                               placeholder="Enter category name" required>
                                        <button type="submit" 
                                                :disabled="isLoading || !newCategoryName.trim()"
                                                class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus disabled:opacity-50 disabled:cursor-not-allowed">
                                            <template x-if="!isLoading">
                                                <div class="flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                    </svg>
                                                    Add
                                                </div>
                                            </template>
                                            <template x-if="isLoading">
                                                <div class="flex items-center">
                                                    <svg class="animate-spin size-4 mr-1" fill="none" viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                    </svg>
                                                    Adding...
                                                </div>
                                            </template>
                                        </button>
                                    </div>
                                    <div x-show="error" x-text="error" class="mt-2 text-sm text-error"></div>
                                </form>
                            </div>

                            <!-- Categories List -->
                            <div class="space-y-3">
                                <h4 class="text-sm font-medium text-slate-700 dark:text-navy-100">Existing Categories ({{ $categories->count() }})</h4>
                                @forelse($categories as $category)
                                    <div class="flex items-center justify-between p-3 rounded-lg border border-slate-200 dark:border-navy-600 bg-white dark:bg-navy-800">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex items-center justify-center size-8 rounded-full bg-primary/10 text-primary dark:bg-accent/10 dark:text-accent">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-medium text-slate-800 dark:text-navy-50">{{ $category->name }}</p>
                                                <p class="text-xs text-slate-500 dark:text-navy-300">
                                                    {{ $category->foodItems->count() }} {{ Str::plural('item', $category->foodItems->count()) }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <button @click="editCategory({{ $category->id }}, '{{ $category->name }}')"
                                                    :disabled="isLoading"
                                                    class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 text-info disabled:opacity-50 disabled:cursor-not-allowed">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </button>
                                            <button @click="confirmDeleteCategory({{ $category->id }}, '{{ $category->name }}')"
                                                    :disabled="{{ $category->foodItems->count() > 0 ? 'true' : 'false' }} || isLoading"
                                                    class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 text-error disabled:opacity-50 disabled:cursor-not-allowed"
                                                    title="{{ $category->foodItems->count() > 0 ? 'Cannot delete category with items' : 'Delete category' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-8">
                                        <div class="flex items-center justify-center size-12 rounded-full bg-slate-100 dark:bg-navy-600 mx-auto mb-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-slate-400 dark:text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                            </svg>
                                        </div>
                                        <p class="text-slate-500 dark:text-navy-300">No categories created yet</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            <!-- Edit Category Modal -->
            <template x-teleport="#x-teleport-target">
                <div class="fixed inset-0 z-[110] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
                     x-show="showEditModal" role="dialog" @keydown.window.escape="showEditModal = false">
                    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
                         @click="showEditModal = false" x-show="showEditModal" x-transition:enter="ease-out"
                         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                         x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"></div>
                    <div class="relative max-w-lg flex flex-col overflow-y-auto rounded-lg bg-white px-4 py-6 transition-all duration-300 dark:bg-navy-700 sm:px-5"
                         x-show="showEditModal" x-transition:enter="easy-out"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100" x-transition:leave="easy-in"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95">
                        
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100">Edit Category</h3>
                            <button @click="showEditModal = false"
                                    class="btn size-8 rounded-full p-0 hover:bg-slate-300/20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        <form @submit.prevent="updateCategory()">
                            <label class="block">
                                <span class="text-slate-600 dark:text-navy-100 font-medium">Category Name</span>
                                <input x-model="editCategoryName" type="text"
                                       :disabled="isLoading"
                                       class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent disabled:opacity-50 disabled:cursor-not-allowed"
                                       placeholder="Enter category name" required>
                            </label>
                            <div x-show="error" x-text="error" class="mt-2 text-sm text-error"></div>

                            <div class="flex justify-end space-x-3 pt-4">
                                <button type="button" @click="showEditModal = false"
                                        :disabled="isLoading"
                                        class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90 disabled:opacity-50 disabled:cursor-not-allowed">
                                    Cancel
                                </button>
                                <button type="submit"
                                        :disabled="isLoading || !editCategoryName.trim()"
                                        class="btn min-w-[7rem] rounded-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <template x-if="!isLoading">
                                        <span>Update</span>
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
            </template>

            <!-- Delete Item Modal -->
            <template x-teleport="#x-teleport-target">
                <div class="fixed inset-0 z-[110] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
                     x-show="showDeleteItemModal" role="dialog" @keydown.window.escape="showDeleteItemModal = false">
                    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
                         @click="showDeleteItemModal = false" x-show="showDeleteItemModal" x-transition:enter="ease-out"
                         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                         x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"></div>
                    <div class="relative max-w-lg flex flex-col overflow-y-auto rounded-lg bg-white px-4 py-6 text-center transition-all duration-300 dark:bg-navy-700 sm:px-5"
                         x-show="showDeleteItemModal" x-transition:enter="easy-out"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100" x-transition:leave="easy-in"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95">
                        
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-16 mx-auto text-error" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        
                        <div class="mt-4">
                            <h3 class="text-xl font-medium text-slate-700 dark:text-navy-100">Delete Food Item</h3>
                            <p class="mt-2 text-slate-500 dark:text-navy-300">
                                Are you sure you want to delete this food item? This action cannot be undone.
                            </p>
                        </div>

                        <div class="flex justify-center space-x-3 pt-4">
                            <button @click="showDeleteItemModal = false"
                                    :disabled="isLoading"
                                    class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90 disabled:opacity-50 disabled:cursor-not-allowed">
                                Cancel
                            </button>
                            <button @click="deleteItem()"
                                    :disabled="isLoading"
                                    class="btn min-w-[7rem] rounded-full bg-error font-medium text-white hover:bg-error-focus focus:bg-error-focus active:bg-error-focus/90 disabled:opacity-50 disabled:cursor-not-allowed">
                                <template x-if="!isLoading">
                                    <span>Delete</span>
                                </template>
                                <template x-if="isLoading">
                                    <div class="flex items-center">
                                        <svg class="animate-spin size-4 mr-2" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Deleting...
                                    </div>
                                </template>
                            </button>
                        </div>
                    </div>
                </div>
            </template>

            <!-- Delete Category Modal -->
            <template x-teleport="#x-teleport-target">
                <div class="fixed inset-0 z-[110] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
                     x-show="showDeleteCategoryModal" role="dialog" @keydown.window.escape="showDeleteCategoryModal = false">
                    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
                         @click="showDeleteCategoryModal = false" x-show="showDeleteCategoryModal" x-transition:enter="ease-out"
                         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                         x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"></div>
                    <div class="relative max-w-lg flex flex-col overflow-y-auto rounded-lg bg-white px-4 py-6 text-center transition-all duration-300 dark:bg-navy-700 sm:px-5"
                         x-show="showDeleteCategoryModal" x-transition:enter="easy-out"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100" x-transition:leave="easy-in"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95">
                        
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-16 mx-auto text-error" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        
                        <div class="mt-4">
                            <h3 class="text-xl font-medium text-slate-700 dark:text-navy-100">Delete Category</h3>
                            <p class="mt-2 text-slate-500 dark:text-navy-300">
                                Are you sure you want to delete the category "<span x-text="deleteCategoryName"></span>"? This action cannot be undone.
                            </p>
                        </div>

                        <div class="flex justify-center space-x-3 pt-4">
                            <button @click="showDeleteCategoryModal = false"
                                    :disabled="isLoading"
                                    class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90 disabled:opacity-50 disabled:cursor-not-allowed">
                                Cancel
                            </button>
                            <button @click="deleteCategory()"
                                    :disabled="isLoading"
                                    class="btn min-w-[7rem] rounded-full bg-error font-medium text-white hover:bg-error-focus focus:bg-error-focus active:bg-error-focus/90 disabled:opacity-50 disabled:cursor-not-allowed">
                                <template x-if="!isLoading">
                                    <span>Delete</span>
                                </template>
                                <template x-if="isLoading">
                                    <div class="flex items-center">
                                        <svg class="animate-spin size-4 mr-2" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Deleting...
                                    </div>
                                </template>
                            </button>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </main>

    @slot('script')
        <script>
            function foodManagement() {
                return {
                    // Modal states
                    showCategoriesModal: false,
                    showEditModal: false,
                    showDeleteItemModal: false,
                    showDeleteCategoryModal: false,
                    
                    // Loading and error states
                    isLoading: false,
                    error: '',
                    
                    // Form data
                    newCategoryName: '',
                    editCategoryId: null,
                    editCategoryName: '',
                    deleteItemId: null,
                    deleteCategoryId: null,
                    deleteCategoryName: '',

                    // Clear error message
                    clearError() {
                        this.error = '';
                    },

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

                    // Add new category
                    async addCategory() {
                        if (!this.newCategoryName.trim() || this.isLoading) return;

                        this.isLoading = true;
                        this.clearError();

                        try {
                            const formData = new FormData();
                            formData.append('name', this.newCategoryName.trim());
                            formData.append('_token', '{{ csrf_token() }}');

                            const response = await fetch('{{ route("dietitian.foods.categories.store") }}', {
                                method: 'POST',
                                body: formData
                            });

                            if (response.ok) {
                                this.showSuccess('Category added successfully!');
                                this.newCategoryName = '';
                                
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1000);
                            } else {
                                throw new Error('Failed to add category');
                            }
                        } catch (error) {
                            console.error('Error:', error);
                            this.error = 'Error adding category. Please try again.';
                        } finally {
                            this.isLoading = false;
                        }
                    },

                    // Edit category
                    editCategory(id, name) {
                        if (this.isLoading) return;
                        this.editCategoryId = id;
                        this.editCategoryName = name;
                        this.clearError();
                        this.showEditModal = true;
                    },

                    async updateCategory() {
                        if (!this.editCategoryName.trim() || this.isLoading) return;

                        this.isLoading = true;
                        this.clearError();

                        try {
                            const formData = new FormData();
                            formData.append('name', this.editCategoryName.trim());
                            formData.append('_token', '{{ csrf_token() }}');
                            formData.append('_method', 'PUT');

                            const response = await fetch(`/dietitian/foods/categories/${this.editCategoryId}`, {
                                method: 'POST',
                                body: formData
                            });

                            if (response.ok) {
                                this.showEditModal = false;
                                this.showSuccess('Category updated successfully!');
                                
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1000);
                            } else {
                                throw new Error('Failed to update category');
                            }
                        } catch (error) {
                            console.error('Error:', error);
                            this.error = 'Error updating category. Please try again.';
                        } finally {
                            this.isLoading = false;
                        }
                    },

                    // Delete category
                    confirmDeleteCategory(id, name) {
                        if (this.isLoading) return;
                        this.deleteCategoryId = id;
                        this.deleteCategoryName = name;
                        this.showDeleteCategoryModal = true;
                    },

                    async deleteCategory() {
                        if (this.isLoading) return;

                        this.isLoading = true;

                        try {
                            const formData = new FormData();
                            formData.append('_token', '{{ csrf_token() }}');
                            formData.append('_method', 'DELETE');

                            const response = await fetch(`/dietitian/foods/categories/${this.deleteCategoryId}`, {
                                method: 'POST',
                                body: formData
                            });

                            if (response.ok) {
                                this.showDeleteCategoryModal = false;
                                this.showSuccess('Category deleted successfully!');
                                
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1000);
                            } else {
                                throw new Error('Failed to delete category');
                            }
                        } catch (error) {
                            console.error('Error:', error);
                            alert('Error deleting category. Please try again.');
                        } finally {
                            this.isLoading = false;
                        }
                    },

                    // Delete food item
                    confirmDeleteItem(id) {
                        if (this.isLoading) return;
                        this.deleteItemId = id;
                        this.showDeleteItemModal = true;
                    },

                    async deleteItem() {
                        if (this.isLoading) return;

                        this.isLoading = true;

                        try {
                            const formData = new FormData();
                            formData.append('_token', '{{ csrf_token() }}');
                            formData.append('_method', 'DELETE');

                            const response = await fetch(`{{ route('dietitian.foods.items.index') }}/${this.deleteItemId}`, {
                                method: 'POST',
                                body: formData
                            });

                            if (response.ok) {
                                this.showDeleteItemModal = false;
                                this.showSuccess('Food item deleted successfully!');
                                
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1000);
                            } else {
                                throw new Error('Failed to delete food item');
                            }
                        } catch (error) {
                            console.error('Error:', error);
                            alert('Error deleting food item. Please try again.');
                        } finally {
                            this.isLoading = false;
                        }
                    }
                };
            }
        </script>
    @endslot
</x-app-layout>