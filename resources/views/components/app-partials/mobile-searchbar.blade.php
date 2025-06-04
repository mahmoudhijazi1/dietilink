<div x-show="$store.breakpoints.isXs && $store.global.isSearchbarActive" x-transition:enter="easy-out transition-all"
    x-transition:enter-start="opacity-0 scale-105" x-transition:enter-end="opacity-100 scale-100"
    x-transition:leave="easy-in transition-all" x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-95"
    class="fixed inset-0 z-[100] flex flex-col bg-white dark:bg-navy-700 sm:hidden">
    <div class="flex items-center space-x-2 bg-slate-100 px-3 pt-2 dark:bg-navy-800">
        <button
            class="btn -ml-1.5 size-7 shrink-0 rounded-full p-0 text-slate-600 hover:bg-slate-300/20 active:bg-slate-300/25 dark:text-navy-100 dark:hover:bg-navy-300/20 dark:active:bg-navy-300/25"
            @click="$store.global.isSearchbarActive = false">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" stroke-width="1.5"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        <input x-effect="$store.global.isSearchbarActive && $nextTick(() => $el.focus() );"
            class="form-input h-8 w-full bg-transparent placeholder-slate-400 dark:placeholder-navy-300" type="text"
            placeholder="Search here..." />
    </div>

    <div x-data="{ activeTab: 'tabAll' }"
        class="is-scrollbar-hidden flex shrink-0 overflow-x-auto bg-slate-100 px-2 text-slate-600 dark:bg-navy-800 dark:text-navy-200">
        <button @click="activeTab = 'tabAll'"
            :class="activeTab === 'tabAll' ? 'border-primary dark:border-accent text-primary dark:text-accent-light' :
                'border-transparent hover:text-slate-800 focus:text-slate-800 dark:hover:text-navy-100 dark:focus:text-navy-100'"
            class="btn shrink-0 rounded-none border-b-2 px-3.5 py-2.5">
            All
        </button>
        <button @click="activeTab = 'tabFiles'"
            :class="activeTab === 'tabFiles' ? 'border-primary dark:border-accent text-primary dark:text-accent-light' :
                'border-transparent hover:text-slate-800 focus:text-slate-800 dark:hover:text-navy-100 dark:focus:text-navy-100'"
            class="btn shrink-0 rounded-none border-b-2 px-3.5 py-2.5">
            Files
        </button>
        <button @click="activeTab = 'tabChats'"
            :class="activeTab === 'tabChats' ? 'border-primary dark:border-accent text-primary dark:text-accent-light' :
                'border-transparent hover:text-slate-800 focus:text-slate-800 dark:hover:text-navy-100 dark:focus:text-navy-100'"
            class="btn shrink-0 rounded-none border-b-2 px-3.5 py-2.5">
            Chats
        </button>
        <button @click="activeTab = 'tabEmails'"
            :class="activeTab === 'tabEmails' ? 'border-primary dark:border-accent text-primary dark:text-accent-light' :
                'border-transparent hover:text-slate-800 focus:text-slate-800 dark:hover:text-navy-100 dark:focus:text-navy-100'"
            class="btn shrink-0 rounded-none border-b-2 px-3.5 py-2.5">
            Emails
        </button>
        <button @click="activeTab = 'tabProjects'"
            :class="activeTab === 'tabProjects' ? 'border-primary dark:border-accent text-primary dark:text-accent-light' :
                'border-transparent hover:text-slate-800 focus:text-slate-800 dark:hover:text-navy-100 dark:focus:text-navy-100'"
            class="btn shrink-0 rounded-none border-b-2 px-3.5 py-2.5">
            Projects
        </button>
        <button @click="activeTab = 'tabTasks'"
            :class="activeTab === 'tabTasks' ? 'border-primary dark:border-accent text-primary dark:text-accent-light' :
                'border-transparent hover:text-slate-800 focus:text-slate-800 dark:hover:text-navy-100 dark:focus:text-navy-100'"
            class="btn shrink-0 rounded-none border-b-2 px-3.5 py-2.5">
            Tasks
        </button>
    </div>

  
</div>
