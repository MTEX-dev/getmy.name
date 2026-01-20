<section>
    <header>
        <div class="flex items-center gap-3">
            <div class="text-getmyname-600 dark:text-getmyname-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                    {{ __('profile.template.title') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('profile.template.description') }}
                </p>
            </div>
        </div>
    </header>

    <form
        method="post"
        action="{{ route('profile.template.update') }}"
        class="mt-8 space-y-8"
    >
        @csrf
        @method('patch')

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
            @foreach ($templates as $template)
                <label class="relative cursor-pointer group">
                    <input 
                        type="radio" 
                        name="template" 
                        value="{{ $template }}" 
                        class="peer sr-only"
                        @checked(old('template', $user->template) === $template)
                        x-on:change="$dispatch('template-preview', '{{ $template }}')"
                    >
                    
                    <div class="overflow-hidden rounded-xl border-2 border-gray-100 dark:border-gray-800 transition-all peer-checked:border-getmyname-500 peer-checked:bg-getmyname-50/30 dark:peer-checked:bg-getmyname-900/10">
                        <div class="aspect-video w-full bg-gray-50 dark:bg-gray-900 flex items-center justify-center border-b border-gray-100 dark:border-gray-800">
                            <svg class="w-8 h-8 text-gray-300 dark:text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16m-7 6h7" />
                            </svg>
                        </div>
                        
                        <div class="p-3 flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-getmyname-600 transition-colors">
                                {{ ucfirst($template) }}
                            </span>
                            <div class="hidden peer-checked:block">
                                <svg class="w-4 h-4 text-getmyname-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </label>
            @endforeach
        </div>

        <div class="flex items-center gap-4 pt-6">
            <x-primary-button>
                {{ __('profile.save_design') ?? __('profile.save') }}
            </x-primary-button>

            @if (session('status') === 'template-updated')
                <div 
                    x-data="{ show: true }" 
                    x-show="show" 
                    x-transition 
                    x-init="setTimeout(() => show = false, 3000)" 
                    class="flex items-center gap-1.5 text-sm font-medium text-green-600 dark:text-green-400"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ __('profile.saved') }}
                </div>
            @endif
        </div>
    </form>
</section>