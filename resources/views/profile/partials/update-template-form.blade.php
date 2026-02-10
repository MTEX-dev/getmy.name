<section>
    <header class="flex items-center gap-4 border-b border-gray-100 dark:border-gray-700 pb-6 mb-8">
        <div class="p-3 bg-gradient-to-br from-getmyname-100 to-getmyname-50 dark:from-getmyname-900 dark:to-gray-800 rounded-2xl text-getmyname-600 dark:text-getmyname-400 shadow-sm ring-1 ring-black/5 dark:ring-white/10">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" /></svg>
        </div>
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                {{ __('profile.template.title') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('profile.template.description') }}
            </p>
        </div>
    </header>

    <form
        method="post"
        action="{{ route('profile.template.update') }}"
        class="mt-8 space-y-8"
    >
        @csrf
        @method('patch')

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
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
                    
                    <div class="relative overflow-hidden rounded-2xl border-2 border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-800 transition-all duration-300 peer-checked:border-getmyname-500 peer-checked:ring-4 peer-checked:ring-getmyname-500/10 peer-checked:-translate-y-1 hover:border-gray-300 dark:hover:border-gray-600 hover:shadow-lg">
                        
                        <!-- Visual Wireframe of Template -->
                        <div class="aspect-[4/3] w-full bg-gray-50 dark:bg-gray-900 flex items-center justify-center border-b border-gray-100 dark:border-gray-800 p-4">
                            @if($template === 'minimal')
                                <!-- Minimal: Centered content, clean -->
                                <svg class="w-full h-full text-gray-300 dark:text-gray-700" viewBox="0 0 100 75" fill="currentColor">
                                    <rect x="20" y="10" width="60" height="8" rx="2" class="text-gray-400 dark:text-gray-600" />
                                    <rect x="30" y="25" width="40" height="4" rx="1" />
                                    <rect x="20" y="35" width="60" height="30" rx="2" opacity="0.5" />
                                </svg>
                            @elseif($template === 'creative')
                                <!-- Creative: Sidebar or asymmetrical -->
                                <svg class="w-full h-full text-gray-300 dark:text-gray-700" viewBox="0 0 100 75" fill="currentColor">
                                    <rect x="10" y="10" width="20" height="55" rx="2" class="text-gray-400 dark:text-gray-600" />
                                    <rect x="35" y="10" width="55" height="15" rx="2" />
                                    <rect x="35" y="30" width="25" height="35" rx="2" opacity="0.5" />
                                    <rect x="65" y="30" width="25" height="35" rx="2" opacity="0.5" />
                                </svg>
                            @elseif($template === 'professional')
                                <!-- Professional: Topbar standard -->
                                <svg class="w-full h-full text-gray-300 dark:text-gray-700" viewBox="0 0 100 75" fill="currentColor">
                                    <rect x="10" y="5" width="80" height="8" rx="1" class="text-gray-400 dark:text-gray-600" />
                                    <rect x="10" y="18" width="25" height="45" rx="2" />
                                    <rect x="40" y="18" width="50" height="15" rx="2" opacity="0.6" />
                                    <rect x="40" y="38" width="50" height="25" rx="2" opacity="0.4" />
                                </svg>
                            @else
                                <!-- Fallback Generic -->
                                <svg class="w-12 h-12 text-gray-200 dark:text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <rect x="3" y="3" width="18" height="18" rx="2" stroke-width="2" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9h18M9 21V9" />
                                </svg>
                            @endif
                        </div>
                        
                        <div class="p-4">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-gray-900 dark:text-gray-100 group-hover:text-getmyname-600 transition-colors">
                                    {{ ucfirst($template) }}
                                </span>
                                <!-- Checkmark Badge -->
                                <div class="hidden peer-checked:flex h-5 w-5 bg-getmyname-500 rounded-full items-center justify-center">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">{{ __('Layout & Design') }}</p>
                        </div>
                    </div>
                </label>
            @endforeach
        </div>

        <div class="flex items-center gap-4 pt-6 border-t border-gray-100 dark:border-gray-700">
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
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    {{ __('profile.saved') }}
                </div>
            @endif
        </div>
    </form>
</section>