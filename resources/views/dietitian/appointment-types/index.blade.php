<x-app-layout title="Appointment Types" is-header-blur="true">
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <!-- Header + Breadcrumbs -->
        <div class="flex items-center space-x-4 py-5 lg:py-6">
            <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
                Appointment Types
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
                <li>Appointment Types</li>
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
        <div class="card pb-4" x-data="appointmentTypesManagement()">
            <div class="px-4 sm:px-5">
                <div class="flex justify-between items-center mt-4 mb-5">
                    <div class="flex items-center space-x-4">
                        <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100">Your Appointment Types</h3>
                        <span class="text-xs text-slate-500 dark:text-navy-300">{{ $appointmentTypes->count() }} types</span>
                    </div>
                    <button @click="showCreateModal = true"
                            class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5 mr-2" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 4v16m8-8H4"/>
                        </svg>
                        Add Appointment Type
                    </button>
                </div>

                <!-- Appointment Types Grid -->
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @forelse($appointmentTypes as $type)
                        <div class="card bg-white p-4 dark:bg-navy-700 border border-slate-200 dark:border-navy-600">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center space-x-3">
                                    <div class="flex items-center justify-center size-10 rounded-full"
                                         style="background-color: {{ $type->color }}20; color: {{ $type->color }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-slate-700 dark:text-navy-100">{{ $type->name }}</h4>
                                        <p class="text-sm text-slate-500 dark:text-navy-300">{{ $type->formatted_duration }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <button @click="editType({{ $type->id }}, '{{ $type->name }}', {{ $type->duration_minutes }}, '{{ $type->color }}', '{{ addslashes($type->description) }}')"
                                            class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 text-info">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    <button @click="confirmDelete({{ $type->id }}, '{{ $type->name }}', {{ $type->canBeDeleted() ? 'true' : 'false' }})"
                                            {{ $type->canBeDeleted() ? '' : 'disabled' }}
                                            class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 text-error disabled:opacity-50 disabled:cursor-not-allowed"
                                            title="{{ $type->canBeDeleted() ? 'Delete type' : 'Cannot delete - has existing appointments' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            
                            @if($type->description)
                                <p class="text-sm text-slate-600 dark:text-navy-300 mb-3">{{ $type->description }}</p>
                            @endif
                            
                            <div class="flex items-center justify-between text-xs text-slate-500 dark:text-navy-400">
                                <span>{{ $type->appointments()->count() }} appointments</span>
                                <span class="inline-flex items-center rounded-full px-2 py-1"
                                      style="background-color: {{ $type->color }}20; color: {{ $type->color }}">
                                    Active
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12">
                            <div class="flex items-center justify-center size-16 rounded-full bg-slate-100 dark:bg-navy-600 mx-auto mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-8 text-slate-400 dark:text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100 mb-2">No appointment types yet</h3>
                            <p class="text-slate-500 dark:text-navy-300 mb-4">Create your first appointment type to get started with scheduling.</p>
                            <button @click="showCreateModal = true"
                                    class="btn bg-primary font-medium text-white hover:bg-primary-focus">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Add First Type
                            </button>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Create/Edit Modal -->
            <template x-teleport="#x-teleport-target">
                <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
                     x-show="showCreateModal" role="dialog" @keydown.window.escape="showCreateModal = false">
                    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
                         @click="showCreateModal = false" x-show="showCreateModal" x-transition:enter="ease-out"
                         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                         x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"></div>
                    <div class="relative w-full max-w-lg flex flex-col overflow-hidden rounded-lg bg-white transition-all duration-300 dark:bg-navy-700"
                         x-show="showCreateModal" x-transition:enter="easy-out"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100" x-transition:leave="easy-in"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95">
                        
                        <!-- Modal Header -->
                        <div class="flex justify-between items-center bg-slate-100 dark:bg-navy-800 px-4 py-3 border-b border-slate-200 dark:border-navy-600">
                            <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span x-text="editMode ? 'Edit Appointment Type' : 'Create Appointment Type'"></span>
                            </h3>
                            <button @click="closeModal()"
                                    class="btn size-8 rounded-full p-0 hover:bg-slate-300/20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Modal Body -->
                        <div class="p-4 space-y-4">
                            <form @submit.prevent="editMode ? updateType() : createType()">
                                <!-- Name -->
                                <label class="block">
                                    <span class="text-slate-600 dark:text-navy-100 font-medium">Name *</span>
                                    <input x-model="form.name" type="text"
                                           :disabled="isLoading"
                                           class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent disabled:opacity-50"
                                           placeholder="e.g. Initial Consultation" required>
                                </label>

                                <!-- Duration -->
                                <label class="block">
                                    <span class="text-slate-600 dark:text-navy-100 font-medium">Duration (minutes) *</span>
                                    <select x-model="form.duration_minutes"
                                            :disabled="isLoading"
                                            class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent disabled:opacity-50"
                                            required>
                                        <option value="">Select Duration</option>
                                        <option value="15">15 minutes</option>
                                        <option value="30">30 minutes</option>
                                        <option value="45">45 minutes</option>
                                        <option value="60">1 hour</option>
                                        <option value="90">1.5 hours</option>
                                        <option value="120">2 hours</option>
                                    </select>
                                </label>

                                <!-- Color -->
                                <label class="block">
                                    <span class="text-slate-600 dark:text-navy-100 font-medium">Color</span>
                                    <div class="flex space-x-2 mt-1.5">
                                        <template x-for="color in defaultColors" :key="color">
                                            <button type="button" 
                                                    @click="form.color = color"
                                                    :disabled="isLoading"
                                                    class="size-8 rounded-full border-2 transition-all disabled:opacity-50"
                                                    :class="form.color === color ? 'border-slate-400 scale-110' : 'border-slate-300'"
                                                    :style="`background-color: ${color}`">
                                            </button>
                                        </template>
                                    </div>
                                </label>

                                <!-- Description -->
                                <label class="block">
                                    <span class="text-slate-600 dark:text-navy-100 font-medium">Description</span>
                                    <textarea x-model="form.description"
                                              :disabled="isLoading"
                                              class="form-textarea mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent disabled:opacity-50"
                                              rows="3"
                                              placeholder="Optional description..."></textarea>
                                </label>

                                <div x-show="error" x-text="error" class="text-sm text-error"></div>

                                <div class="flex justify-end space-x-3 pt-4">
                                    <button type="button" @click="closeModal()"
                                            :disabled="isLoading"
                                            class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 disabled:opacity-50">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                            :disabled="isLoading || !form.name || !form.duration_minutes"
                                            class="btn min-w-[7rem] rounded-full bg-primary font-medium text-white hover:bg-primary-focus dark:bg-accent dark:hover:bg-accent-focus disabled:opacity-50">
                                        <template x-if="!isLoading">
                                            <span x-text="editMode ? 'Update' : 'Create'"></span>
                                        </template>
                                        <template x-if="isLoading">
                                            <div class="flex items-center">
                                                <svg class="animate-spin size-4 mr-2" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                                <span x-text="editMode ? 'Updating...' : 'Creating...'"></span>
                                            </div>
                                        </template>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </template>

            <!-- Delete Modal -->
            <template x-teleport="#x-teleport-target">
                <div class="fixed inset-0 z-[110] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
                     x-show="showDeleteModal" role="dialog" @keydown.window.escape="showDeleteModal = false">
                    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
                         @click="showDeleteModal = false" x-show="showDeleteModal" x-transition:enter="ease-out"
                         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                         x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"></div>
                    <div class="relative max-w-lg flex flex-col overflow-y-auto rounded-lg bg-white px-4 py-6 text-center transition-all duration-300 dark:bg-navy-700 sm:px-5"
                         x-show="showDeleteModal" x-transition:enter="easy-out"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100" x-transition:leave="easy-in"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95">
                        
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-16 mx-auto text-error" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        
                        <div class="mt-4">
                            <h3 class="text-xl font-medium text-slate-700 dark:text-navy-100">Delete Appointment Type</h3>
                            <p class="mt-2 text-slate-500 dark:text-navy-300">
                                Are you sure you want to delete "<span x-text="deleteTypeName"></span>"? This action cannot be undone.
                            </p>
                        </div>

                        <div class="flex justify-center space-x-3 pt-4">
                            <button @click="showDeleteModal = false"
                                    :disabled="isLoading"
                                    class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 disabled:opacity-50">
                                Cancel
                            </button>
                            <button @click="deleteType()"
                                    :disabled="isLoading"
                                    class="btn min-w-[7rem] rounded-full bg-error font-medium text-white hover:bg-error-focus disabled:opacity-50">
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
            function appointmentTypesManagement() {
                return {
                    // Modal states
                    showCreateModal: false,
                    showDeleteModal: false,
                    editMode: false,
                    
                    // Loading and error states
                    isLoading: false,
                    error: '',
                    
                    // Form data
                    form: {
                        name: '',
                        duration_minutes: '',
                        color: '#3B82F6',
                        description: ''
                    },
                    
                    // Delete data
                    deleteTypeId: null,
                    deleteTypeName: '',
                    
                    // Available colors
                    defaultColors: [
                        '#3B82F6', '#10B981', '#F59E0B', '#8B5CF6', 
                        '#EF4444', '#06B6D4', '#84CC16', '#F97316'
                    ],

                    // Reset form
                    resetForm() {
                        this.form = {
                            name: '',
                            duration_minutes: '',
                            color: '#3B82F6',
                            description: ''
                        };
                        this.editMode = false;
                        this.error = '';
                    },

                    // Close modal
                    closeModal() {
                        this.showCreateModal = false;
                        this.resetForm();
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

                    // Create appointment type
                    async createType() {
                        if (this.isLoading) return;

                        this.isLoading = true;
                        this.error = '';

                        try {
                            const formData = new FormData();
                            formData.append('name', this.form.name);
                            formData.append('duration_minutes', this.form.duration_minutes);
                            formData.append('color', this.form.color);
                            formData.append('description', this.form.description);
                            formData.append('_token', '{{ csrf_token() }}');

                            const response = await fetch('{{ route("dietitian.appointment-types.store") }}', {
                                method: 'POST',
                                body: formData
                            });

                            if (response.ok) {
                                this.closeModal();
                                this.showSuccess('Appointment type created successfully!');
                                setTimeout(() => window.location.reload(), 1000);
                            } else {
                                const data = await response.json();
                                this.error = data.message || 'Failed to create appointment type';
                            }
                        } catch (error) {
                            console.error('Error:', error);
                            this.error = 'Error creating appointment type. Please try again.';
                        } finally {
                            this.isLoading = false;
                        }
                    },

                    // Edit appointment type
                    editType(id, name, duration, color, description) {
                        this.editMode = true;
                        this.form = {
                            id: id,
                            name: name,
                            duration_minutes: duration,
                            color: color,
                            description: description || ''
                        };
                        this.error = '';
                        this.showCreateModal = true;
                    },

                    // Update appointment type
                    async updateType() {
                        if (this.isLoading) return;

                        this.isLoading = true;
                        this.error = '';

                        try {
                            const formData = new FormData();
                            formData.append('name', this.form.name);
                            formData.append('duration_minutes', this.form.duration_minutes);
                            formData.append('color', this.form.color);
                            formData.append('description', this.form.description);
                            formData.append('_token', '{{ csrf_token() }}');
                            formData.append('_method', 'PUT');

                            const response = await fetch(`{{ route("dietitian.appointment-types.index") }}/${this.form.id}`, {
                                method: 'POST',
                                body: formData
                            });

                            if (response.ok) {
                                this.closeModal();
                                this.showSuccess('Appointment type updated successfully!');
                                setTimeout(() => window.location.reload(), 1000);
                            } else {
                                const data = await response.json();
                                this.error = data.message || 'Failed to update appointment type';
                            }
                        } catch (error) {
                            console.error('Error:', error);
                            this.error = 'Error updating appointment type. Please try again.';
                        } finally {
                            this.isLoading = false;
                        }
                    },

                    // Confirm delete
                    confirmDelete(id, name, canDelete) {
                        if (!canDelete) {
                            alert('Cannot delete this appointment type because it has existing appointments.');
                            return;
                        }
                        this.deleteTypeId = id;
                        this.deleteTypeName = name;
                        this.showDeleteModal = true;
                    },

                    // Delete appointment type
                    async deleteType() {
                        if (this.isLoading) return;

                        this.isLoading = true;

                        try {
                            const formData = new FormData();
                            formData.append('_token', '{{ csrf_token() }}');
                            formData.append('_method', 'DELETE');

                            const response = await fetch(`{{ route("dietitian.appointment-types.index") }}/${this.deleteTypeId}`, {
                                method: 'POST',
                                body: formData
                            });

                            if (response.ok) {
                                this.showDeleteModal = false;
                                this.showSuccess('Appointment type deleted successfully!');
                                setTimeout(() => window.location.reload(), 1000);
                            } else {
                                throw new Error('Failed to delete appointment type');
                            }
                        } catch (error) {
                            console.error('Error:', error);
                            alert('Error deleting appointment type. Please try again.');
                        } finally {
                            this.isLoading = false;
                        }
                    }
                };
            }
        </script>
    @endslot
</x-app-layout>