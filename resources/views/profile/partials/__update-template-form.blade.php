<section>
    <header>
        <div class="flex items-center gap-3">
            <div class="p-2 bg-getmyname-100 dark:bg-getmyname-900/30 rounded-lg text-getmyname-600 dark:text-getmyname-400">
                <i class="bi bi-palette2 text-xl"></i>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
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

        <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach ($templates as $template)
                <label class="relative group cursor-pointer">
                    <input 
                        type="radio" 
                        name="template" 
                        value="{{ $template }}" 
                        class="peer sr-only"
                        @checked(old('template', $user->template) === $template)
                        x-on:change="$dispatch('template-preview', '{{ $template }}')"
                    >
                    
                    <div class="h-full border-2 border-gray-200 dark:border-gray-700 rounded-2xl p-1 transition-all peer-checked:border-getmyname-500 peer-checked:ring-2 peer-checked:ring-getmyname-500/20 group-hover:border-getmyname-300 dark:group-hover:border-gray-600">
                        <div class="aspect-[4/3] rounded-xl bg-gray-100 dark:bg-gray-900 mb-3 overflow-hidden border border-gray-100 dark:border-gray-800">
                            {{-- Optional: Template Thumbnails --}}
                            <div class="w-full h-full flex items-center justify-center text-gray-400 dark:text-gray-600 italic text-sm">
                                <i class="bi bi-layout-text-sidebar-reverse text-4xl mb-2"></i>
                            </div>
                        </div>
                        
                        <div class="px-3 pb-3 flex items-center justify-between">
                            <span class="font-bold text-gray-700 dark:text-gray-300">{{ ucfirst($template) }}</span>
                            <div class="opacity-0 peer-checked:group-[]:opacity-100 transition-opacity">
                                <i class="bi bi-check-circle-fill text-getmyname-500 text-lg"></i>
                            </div>
                        </div>
                    </div>
                </label>
            @endforeach
        </div>

        <div class="flex items-center gap-4 border-t border-gray-100 dark:border-gray-700 pt-6">
            <x-primary-button class="px-8 py-3">
                {{ __('profile.save_design') ?? __('profile.save') }}
            </x-primary-button>

            @if (session('status') === 'template-updated')
                <div 
                    x-data="{ show: true }" 
                    x-show="show" 
                    x-transition 
                    x-init="setTimeout(() => show = false, 3000)" 
                    class="flex items-center gap-2 text-sm font-bold text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/20 px-4 py-2 rounded-lg"
                >
                    <i class="bi bi-check-lg"></i>
                    {{ __('profile.saved') }}
                </div>
            @endif
        </div>
    </form>
</section>