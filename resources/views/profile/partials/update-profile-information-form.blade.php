<section>
    <header class="flex items-center gap-4 border-b border-gray-100 dark:border-gray-700 pb-6 mb-8">
        <div class="p-3 bg-gradient-to-br from-getmyname-100 to-getmyname-50 dark:from-getmyname-900 dark:to-gray-800 rounded-2xl text-getmyname-600 dark:text-getmyname-400 shadow-sm ring-1 ring-black/5 dark:ring-white/10">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
        </div>
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                {{ __('profile.profile_title') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('profile.profile_subtitle') }}
            </p>
        </div>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-8">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-6">
            <!-- Name -->
            <div class="lg:col-span-6">
                <x-input-label for="name" :value="__('strings.name')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <!-- Username -->
            <div class="lg:col-span-6">
                <x-input-label for="username" :value="__('strings.username')" />
                <div class="relative mt-1">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500 dark:text-gray-400">@</span>
                    <x-text-input id="username" name="username" type="text" class="block w-full pl-8" :value="old('username', $user->username)" autocomplete="username" />
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('username')" />
            </div>

            <!-- Email -->
            <div class="lg:col-span-6">
                <x-input-label for="email" :value="__('strings.email')" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>

            <!-- Title -->
            <div class="lg:col-span-6">
                <x-input-label for="title" :value="__('profile.title') . ' (' . __('profile.optional') . ')'" />
                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $user->title)" autocomplete="title" placeholder="e.g. Senior Product Designer" />
                <x-input-error class="mt-2" :messages="$errors->get('title')" />
            </div>

            <!-- Pronouns -->
            <div class="lg:col-span-4">
                <div class="flex items-center gap-x-2">
                    <x-input-label for="pronouns" :value="__('profile.pronouns') . ' (' . __('profile.optional') . ')'" />
                    <!-- Badge Component placeholder if needed -->
                    @if(view()->exists('components.badges.new'))
                        @include('components.badges.new')
                    @endif
                </div>
                <div x-data="customSelect({ initialValue: @js(old('pronouns', $user->pronouns)),  presetOptions: ['they/them', 'she/her', 'he/him'] })">
                    <select id="pronouns" name="pronouns" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-getmyname-500 dark:focus:border-getmyname-600 focus:ring-getmyname-500 dark:focus:ring-getmyname-600 rounded-lg shadow-sm" x-model="selectedValue">
                        <option value="">{{ __('profile.pronouns_none') }}</option>
                        <template x-for="opt in presetOptions" :key="opt">
                            <option :value="opt" x-text="opt"></option>
                        </template>
                        <option value="Custom">{{ __('profile.pronouns_custom_option') }}</option>
                    </select>
                    
                    <div x-show="isCustom" style="display: none;" class="mt-2" x-transition>
                        <x-text-input x-ref="manualInput" id="pronouns_manual" name="pronouns_manual" type="text" class="block w-full" placeholder="{{ __('profile.pronouns_custom') }}" x-model="manualValue" />
                    </div>
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('pronouns')" />
                <x-input-error class="mt-2" :messages="$errors->get('pronouns_manual')" />
            </div>

            <!-- Location -->
            <div class="lg:col-span-4">
                <x-input-label for="location" :value="__('profile.location') . ' (' . __('profile.optional') . ')'" />
                
                <div x-data="customSelect({ 
                    initialValue: @js(old('location', $user->location)), 
                    presetOptions: ['New York', 'London', 'Paris', 'Tokyo', 'Berlin', 'Rome', 'Madrid', 'Sydney', 'Dubai', 'Singapore', 'Germany'] 
                })">
                    <select id="location" name="location" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-getmyname-500 dark:focus:border-getmyname-600 focus:ring-getmyname-500 dark:focus:ring-getmyname-600 rounded-lg shadow-sm" x-model="selectedValue">
                        <option value="">{{ __('profile.location_none') ?? 'Select Location' }}</option>
                        <template x-for="loc in presetOptions" :key="loc">
                            <option :value="loc" x-text="loc"></option>
                        </template>
                        <option value="Custom">{{ __('profile.location_manual') }}</option>
                    </select>

                    <div x-show="isCustom" style="display: none;" class="mt-2" x-transition>
                        <x-text-input x-ref="manualInput" id="location_manual" name="location_manual" type="text" class="block w-full" x-model="manualValue" placeholder="City, Country" />
                    </div>
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('location')" />
                <x-input-error class="mt-2" :messages="$errors->get('location_manual')" />
            </div>

            <!-- Bio -->
            <div class="lg:col-span-12">
                <x-input-label for="bio" :value="__('profile.bio') . ' (' . __('profile.optional') . ')'" />
                <x-textarea-input id="bio" name="bio" class="mt-1 block w-full" :value="old('bio', $user->bio)" autocomplete="bio" rows="4" placeholder="Tell us a little bit about yourself..." />
                <x-input-error class="mt-2" :messages="$errors->get('bio')" />
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-gray-100 dark:border-gray-700">
            <x-primary-button>{{ __('profile.save') }}</x-primary-button>
            @if (session('status') === 'profile-updated')
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="flex items-center gap-2 text-sm text-green-600 dark:text-green-400 font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ __('profile.saved') }}
                </div>
            @endif
        </div>
    </form>
</section>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('customSelect', (config) => ({
            selectedValue: '',
            manualValue: '',
            isCustom: false,
            presetOptions: config.presetOptions || [],
            
            init() {
                const startVal = config.initialValue;
                let targetSelectValue = '';

                if (!startVal) {
                    targetSelectValue = '';
                    this.isCustom = false;
                } 
                else if (this.presetOptions.includes(startVal)) {
                    targetSelectValue = startVal;
                    this.isCustom = false;
                } 
                else {
                    targetSelectValue = 'Custom';
                    this.manualValue = startVal;
                    this.isCustom = true;
                }

                this.$nextTick(() => {
                    this.selectedValue = targetSelectValue;
                });

                this.$watch('selectedValue', (value) => {
                    this.isCustom = value === 'Custom';
                    if (this.isCustom) {
                        this.$nextTick(() => { 
                            if(this.$refs.manualInput) this.$refs.manualInput.focus(); 
                        });
                    }
                });
            }
        }));
    });
</script>