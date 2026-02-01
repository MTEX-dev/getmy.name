<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('profile.profile_title') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('profile.profile_subtitle') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <!-- Name -->
            <div class="lg:col-span-2">
                <x-input-label for="name" :value="__('strings.name')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <!-- Username -->
            <div>
                <x-input-label for="username" :value="__('strings.username')" />
                <x-text-input id="username" name="username" type="text" class="mt-1 block w-full" :value="old('username', $user->username)" autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('username')" />
            </div>

            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('strings.email')" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>

            <!-- Title -->
            <div class="lg:col-span-2">
                <x-input-label for="title" :value="__('profile.title') . ' (' . __('profile.optional') . ')'" />
                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $user->title)" autocomplete="title" />
                <x-input-error class="mt-2" :messages="$errors->get('title')" />
            </div>

            <!-- Pronouns (New) -->
            <div class="lg:col-span-1">
                <x-input-label for="pronouns" :value="__('profile.pronouns') . ' (' . __('profile.optional') . ')'" />
                <div x-data="customSelect({ 
                    initialValue: '{{ old('pronouns', $user->pronouns) }}', 
                    options: ['{{ __('profile.pronouns_they') }}', '{{ __('profile.pronouns_she') }}', '{{ __('profile.pronouns_he') }}'],
                    noneValue: '{{ __('profile.pronouns_none') }}'
                })" x-init="init()">
                    <select id="pronouns" name="pronouns" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-getmyname-500 dark:focus:border-getmyname-600 focus:ring-getmyname-500 dark:focus:ring-getmyname-600 rounded-md shadow-sm" x-model="selectedValue">
                        <option value="">{{ __('profile.pronouns_none') }}</option>
                        <template x-for="opt in options" :key="opt">
                            <option :value="opt" x-text="opt"></option>
                        </template>
                        <option value="Custom">{{ __('profile.pronouns_custom_option') }}</option>
                    </select>
                    <x-text-input x-ref="manualInput" x-show="isCustom" id="pronouns_manual" name="pronouns_manual" type="text" class="mt-2 block w-full" placeholder="{{ __('profile.pronouns_custom') }}" x-bind:value="isCustom ? internalManualValue : ''" x-on:input="internalManualValue = $event.target.value" />
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('pronouns')" />
            </div>

            <!-- Location -->
            <div class="lg:col-span-1">
                <x-input-label for="location" :value="__('profile.location') . ' (' . __('profile.optional') . ')'" />
                <div x-data="customSelect({ 
                    initialValue: '{{ old('location', $user->location) }}', 
                    options: ['New York', 'London', 'Paris', 'Tokyo', 'Berlin', 'Rome', 'Madrid', 'Sydney', 'Dubai', 'Singapore', 'Germany'] 
                })" x-init="init()">
                    <select id="location" name="location" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-getmyname-500 dark:focus:border-getmyname-600 focus:ring-getmyname-500 dark:focus:ring-getmyname-600 rounded-md shadow-sm" x-model="selectedValue">
                        <template x-for="loc in options" :key="loc">
                            <option :value="loc" x-text="loc"></option>
                        </template>
                        <option value="Custom">{{ __('profile.location_manual') }}</option>
                    </select>
                    <x-text-input x-ref="manualInput" x-show="isCustom" id="location_manual" name="location_manual" type="text" class="mt-2 block w-full" x-bind:value="isCustom ? internalManualValue : ''" x-on:input="internalManualValue = $event.target.value" />
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('location')" />
            </div>

            <!-- Bio -->
            <div class="col-span-1 md:col-span-2 lg:col-span-3 xl:col-span-4">
                <x-input-label for="bio" :value="__('profile.bio') . ' (' . __('profile.optional') . ')'" />
                <x-textarea-input id="bio" name="bio" class="mt-1 block w-full" :value="old('bio', $user->bio)" autocomplete="bio" />
                <x-input-error class="mt-2" :messages="$errors->get('bio')" />
            </div>
        </div>

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div>
                <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                    {{ __('profile.email_unverified') }}

                    <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-getmyname-500 dark:focus:ring-offset-gray-800">
                        {{ __('profile.resend_verification') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                        {{ __('profile.verification_sent') }}
                    </p>
                @endif
            </div>
        @endif

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('profile.save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('profile.saved') }}
                </p>
            @endif
        </div>
    </form>
</section>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('customSelect', (config) => ({
            selectedValue: config.initialValue || '',
            internalManualValue: '',
            isCustom: false,
            options: config.options || [],
            
            init() {
                this.$watch('selectedValue', (value) => {
                    this.isCustom = value === 'Custom';
                });

                if (this.selectedValue && !this.options.includes(this.selectedValue) && this.selectedValue !== '') {
                    this.internalManualValue = this.selectedValue;
                    this.selectedValue = 'Custom';
                    this.isCustom = true;
                } else if (this.selectedValue === 'Custom') {
                    this.isCustom = true;
                }
            }
        }));
    });
</script>