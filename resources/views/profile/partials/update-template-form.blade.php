<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('profile.template.title') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('profile.template.description') }}
        </p>
    </header>

    <form
        method="post"
        action="{{ route('profile.template.update') }}"
        class="mt-6 space-y-6"
    >
        @csrf
        @method('patch')

        <div>
            <x-input-label for="template" :value="__('profile.template.label')" />
            <select
                id="template"
                name="template"
                class="mt-1 block w-full rounded-md border-gray-300 bg-white py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 sm:text-sm"
            >
                @foreach (['default', 'modern', 'aether', 'serenity', 'codely', 'test'] as $template)
                    <option
                        value="{{ $template }}"
                        @if ($user->template === $template) selected @endif
                    >
                        {{ ucfirst($template) }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('template')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('profile.save') }}</x-primary-button>

            @if (session('status') === 'template-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >
                    {{ __('profile.saved') }}
                </p>
            @endif
        </div>
    </form>
</section>