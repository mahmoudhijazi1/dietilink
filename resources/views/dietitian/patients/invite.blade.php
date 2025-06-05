<x-app-layout title="Invite Patient" is-header-blur="true">
    <!-- Main Content Wrapper -->
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="flex items-center space-x-4 py-5 lg:py-6">
            <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
                Invite Patient
            </h2>
            <div class="hidden h-full py-1 sm:flex">
                <div class="h-full w-px bg-slate-300 dark:bg-navy-600"></div>
            </div>
            <ul class="hidden flex-wrap items-center space-x-2 sm:flex">
                <li class="flex items-center space-x-2">
                    <a class="text-primary transition-colors hover:text-primary-focus dark:text-accent-light dark:hover:text-accent"
                        href="{{ route('dietitian.dashboard') }}">Dashboard</a>
                    <svg x-ignore xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </li>
                <li class="flex items-center space-x-2">
                    <a class="text-primary transition-colors hover:text-primary-focus dark:text-accent-light dark:hover:text-accent"
                        href="{{ route('dietitian.patients.index') }}">Patients</a>
                    <svg x-ignore xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </li>
                <li>Invite</li>
            </ul>
        </div>

        <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
            <div class="col-span-12 lg:col-span-8">
                <div class="card" x-data="{
                    name: '',
                    email: '',
                    successMessage: '',
                    errors: [],
                    inviteLink: '',
                    isLoading: false,
                    shareMethod: 'email',
                    linkCopied: false,
                    emailSent: false,
                    
                    async submitForm() {
                        this.successMessage = '';
                        this.errors = [];
                        this.inviteLink = '';
                        this.isLoading = true;
                        this.linkCopied = false;
                        this.emailSent = false;

                        try {
                            const response = await axios.post('{{ route('dietitian.patients.invite.submit') }}', {
                                name: this.name,
                                email: this.email
                            });

                            this.successMessage = response.data.message || 'Invitation created successfully!';
                            this.inviteLink = response.data.invite_link;
                            this.generateQRCode();
                            
                        } catch (error) {
                            if (error.response && error.response.status === 422) {
                                this.errors = Object.values(error.response.data.errors).flat();
                            } else if (error.response) {
                                this.errors = [error.response.data.message || 'Unexpected server error.'];
                            } else {
                                this.errors = ['Request failed. Check your connection.'];
                            }
                        } finally {
                            this.isLoading = false;
                        }
                    },

                    async sendEmail() {
                        try {
                            this.emailSent = true;
                            this.successMessage = 'Email sent successfully!';
                        } catch (error) {
                            this.errors = ['Failed to send email. Please try again.'];
                        }
                    },

                    async copyToClipboard() {
                        try {
                            await navigator.clipboard.writeText(this.inviteLink);
                            this.linkCopied = true;
                            setTimeout(() => {
                                this.linkCopied = false;
                            }, 3000);
                        } catch (error) {
                            const textArea = document.createElement('textarea');
                            textArea.value = this.inviteLink;
                            document.body.appendChild(textArea);
                            textArea.select();
                            document.execCommand('copy');
                            document.body.removeChild(textArea);
                            this.linkCopied = true;
                            setTimeout(() => {
                                this.linkCopied = false;
                            }, 3000);
                        }
                    },

                    generateQRCode() {
                        setTimeout(() => {
                            const qrCodeElement = document.getElementById('qrcode');
                            if (qrCodeElement && this.inviteLink && typeof QRCode !== 'undefined') {
                                qrCodeElement.innerHTML = '';
                                QRCode.toCanvas(qrCodeElement, this.inviteLink, {
                                    width: 200,
                                    margin: 2,
                                    color: {
                                        dark: '#000000',
                                        light: '#FFFFFF'
                                    }
                                });
                            }
                        }, 100);
                    },

                    downloadQR() {
                        const canvas = document.querySelector('#qrcode canvas');
                        if (canvas) {
                            const link = document.createElement('a');
                            link.download = `patient-invite-${this.email}.png`;
                            link.href = canvas.toDataURL();
                            link.click();
                        }
                    }
                }">
                    <div class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                        <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                            Invite a New Patient
                        </h2>
                        <div class="flex justify-center space-x-2">
                            <a href="{{ route('dietitian.patients.index') }}"
                                class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-700 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                                Cancel
                            </a>
                        </div>
                    </div>
                    <div class="p-4 sm:p-5">
                        <!-- Success Message -->
                        <div x-show="successMessage" class="alert flex rounded-lg border border-success px-4 py-4 text-success sm:px-5 mb-5" x-transition>
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span x-text="successMessage"></span>
                        </div>

                        <!-- Error Messages -->
                        <div x-show="errors.length" class="alert flex rounded-lg border border-error px-4 py-4 text-error sm:px-5 mb-5" x-transition>
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            <div>
                                <ul class="list-disc list-inside">
                                    <template x-for="error in errors" :key="error">
                                        <li x-text="error"></li>
                                    </template>
                                </ul>
                            </div>
                        </div>

                        <!-- Loading State -->
                        <div x-show="isLoading" class="alert flex rounded-lg border border-info px-4 py-4 text-info sm:px-5 mb-5" x-transition>
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            <span>Sending invitation...</span>
                        </div>

                        <form @submit.prevent="submitForm" class="mt-4 space-y-5">
                            <label class="block">
                                <span class="font-medium text-slate-600 dark:text-navy-100">Patient Name</span>
                                <input
                                    x-model="name"
                                    class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="Enter patient's full name" 
                                    type="text" 
                                    required 
                                    :disabled="isLoading" />
                            </label>
                            <label class="block">
                                <span class="font-medium text-slate-600 dark:text-navy-100">Email Address</span>
                                <input
                                    x-model="email"
                                    class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="Enter patient's email address" 
                                    type="email" 
                                    required 
                                    :disabled="isLoading" />
                            </label>

                            <div class="space-y-2 pt-4">
                                <div class="flex justify-end space-x-2">
                                    <button type="button" onclick="window.location.href='{{ route('dietitian.patients.index') }}'"
                                        class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-700 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90"
                                        :disabled="isLoading">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                        class="btn min-w-[7rem] rounded-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90"
                                        :disabled="isLoading">
                                        <span x-show="!isLoading">Send Invitation</span>
                                        <span x-show="isLoading" class="flex items-center">
                                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            Sending...
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Invitation Link Result -->
                        <div x-show="inviteLink" class="mt-6 p-4 rounded-lg bg-slate-100 dark:bg-navy-600" x-transition>
                            <h3 class="font-medium text-slate-700 dark:text-navy-100 mb-3">Invitation Created Successfully!</h3>
                            
                            <!-- Method Selection -->
                            <div class="mb-4">
                                <span class="font-medium text-slate-600 dark:text-navy-100 text-sm">Choose how to share:</span>
                                <div class="flex space-x-4 mt-2">
                                    <label class="flex items-center">
                                        <input type="radio" x-model="shareMethod" value="email" class="form-radio text-primary">
                                        <span class="ml-2 text-sm">Email Link</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" x-model="shareMethod" value="copy" class="form-radio text-primary">
                                        <span class="ml-2 text-sm">Copy Link</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" x-model="shareMethod" value="qr" class="form-radio text-primary">
                                        <span class="ml-2 text-sm">QR Code</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Email Method -->
                            <div x-show="shareMethod === 'email'" x-transition>
                                <p class="text-sm text-slate-600 dark:text-navy-300 mb-3">
                                    An invitation email will be automatically sent to <strong x-text="email"></strong>
                                </p>
                                <button @click="sendEmail" class="btn bg-success text-white hover:bg-success-focus" :disabled="emailSent">
                                    <span x-show="!emailSent">📧 Send Email Invitation</span>
                                    <span x-show="emailSent">✅ Email Sent!</span>
                                </button>
                            </div>

                            <!-- Copy Link Method -->
                            <div x-show="shareMethod === 'copy'" x-transition>
                                <p class="text-sm text-slate-600 dark:text-navy-300 mb-3">Copy this link and send it to your patient:</p>
                                <div class="flex space-x-2">
                                    <input 
                                        type="text" 
                                        :value="inviteLink" 
                                        readonly 
                                        class="form-input flex-1 rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm dark:border-navy-450 dark:bg-navy-700"
                                    />
                                    <button @click="copyToClipboard" class="btn bg-info text-white hover:bg-info-focus">
                                        <span x-show="!linkCopied">📋 Copy</span>
                                        <span x-show="linkCopied">✅ Copied!</span>
                                    </button>
                                </div>
                            </div>

                            <!-- QR Code Method -->
                            <div x-show="shareMethod === 'qr'" x-transition>
                                <p class="text-sm text-slate-600 dark:text-navy-300 mb-3">Share this QR code with your patient:</p>
                                <div class="flex flex-col items-center space-y-3">
                                    <div id="qrcode" class="bg-white p-4 rounded-lg"></div>
                                    <button @click="downloadQR" class="btn bg-primary text-white hover:bg-primary-focus">
                                        💾 Download QR Code
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-12 lg:col-span-4">
                <div class="card">
                    <div class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                        <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                            About Patient Invitations
                        </h2>
                    </div>
                    <div class="p-4 sm:p-5">
                        <div class="space-y-4">
                            <div class="flex items-start space-x-3">
                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary/10 text-primary dark:bg-accent/10 dark:text-accent">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-slate-700 dark:text-navy-100">Multiple Sharing Options</p>
                                    <p class="text-xs+ text-slate-500 dark:text-navy-200">
                                        Send via email, copy the link, or generate a QR code for easy sharing.
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary/10 text-primary dark:bg-accent/10 dark:text-accent">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-slate-700 dark:text-navy-100">Secure Setup</p>
                                    <p class="text-xs+ text-slate-500 dark:text-navy-200">
                                        Patients will create their own secure password when they first sign up.
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary/10 text-primary dark:bg-accent/10 dark:text-accent">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-slate-700 dark:text-navy-100">Privacy Protected</p>
                                    <p class="text-xs+ text-slate-500 dark:text-navy-200">
                                        Patient data is securely stored and accessible only to you and the patient.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @slot('script')
    <!-- QR Code Library -->
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>
    @endslot
</x-app-layout>