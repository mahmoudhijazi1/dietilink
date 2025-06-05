<x-app-layout title="Edit Food Category" is-header-blur="true">
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="flex items-center justify-between mt-5 mb-5">
            <h1 class="text-xl font-medium text-slate-700 dark:text-navy-100">Edit Food Category</h1>
            <a href="{{ route('dietitian.foods.categories.index') }}"
               class="btn bg-slate-150 text-slate-800 hover:bg-slate-200 focus:bg-slate-200 dark:bg-navy-600 dark:text-navy-100 dark:hover:bg-navy-500">
                ← Back to Categories
            </a>
        </div>

        @if($errors->any())
            <div class="alert flex rounded-lg border border-error px-4 py-4 text-error sm:px-5 mb-5">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM9 8a1 1 0 012 0v3a1 1 0 11-2 0V8zm2 5a1 1 0 10-2 0 1 1 0 002 0z"
                          clip-rule="evenodd" />
                </svg>
                <ul class="ml-3 list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('dietitian.foods.categories.update', $foodCategory->id) }}" method="POST"
              class="card space-y-4 p-4 sm:p-5">
            @csrf
            @method('PUT')

            <label class="block">
                <span class="text-slate-600 dark:text-navy-100 font-medium">Category Name</span>
                <span class="relative mt-1.5 flex">
                    <input name="name" type="text" value="{{ old('name', $foodCategory->name) }}"
                           class="form-input peer w-full rounded-lg border border-slate-300 px-3 py-2 placeholder:text-slate-400 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:text-navy-100 dark:placeholder:text-navy-300"
                           placeholder="Enter category name" required>
                </span>
            </label>

            <div class="flex justify-end pt-4">
                <button type="submit"
                        class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus">
                    Update
                </button>
            </div>
        </form>
    </main>
</x-app-layout>
