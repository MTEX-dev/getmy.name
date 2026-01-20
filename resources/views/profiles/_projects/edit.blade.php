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
            <div>
                <x-input-label for="name" :value="__('strings.name')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="username" :value="__('strings.username')" />
                <x-text-input id="username" name="username" type="text" class="mt-1 block w-full" :value="old('username', $user->username)" autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('username')" />
            </div>

            <div>
                <x-input-label for="email" :value="__('strings.email')" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>

            <div>
                <x-input-label for="title" :value="__('profile.title') . ' (' . __('profile.optional') . ')'" />
                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $user->title)" autocomplete="title" />
                <x-input-error class="mt-2" :messages="$errors->get('title')" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-1">
                <x-input-label for="location" :value="__('profile.location') . ' (' . __('profile.optional') . ')'" />
                <select id="location" name="location" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-getmyname-500 dark:focus:border-getmyname-600 focus:ring-getmyname-500 dark:focus:ring-getmyname-600 rounded-md shadow-sm" x-data="locationSelect()" x-init="init()">
                    <template x-for="loc in locations">
                        <option :value="loc" x-text="loc" :selected="loc === locationValue"></option>
                    </template>
                    <option value="Type Manually" :selected="locationValue === 'Type Manually'">{{ __('profile.location_manual') }}</option>
                </select>
                <x-text-input x-ref="manualInput" x-show="isManual" id="location_manual" name="location_manual" type="text" class="mt-1 block w-full" x-bind:value="locationValue === 'Type Manually' ? '' : locationValue" x-on:input="locationValue = $event.target.value" />
                <x-input-error class="mt-2" :messages="$errors->get('location')" />
            </div>

            <div class="md:col-span-1">
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
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('profile.saved') }}</p>
            @endif
        </div>
    </form>
</section>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('locationSelect', () => ({
            locationValue: '{{ old('location', $user->location) }}',
            isManual: false,
            locations: [
                'New York',
                'London',
                'Paris',
                'Tokyo',
                'Berlin',
                'Rome',
                'Madrid',
                'Sydney',
                'Dubai',
                'Singapore',
                'Germany'
            ],
            init() {
                this.$watch('locationValue', value => {
                    this.isManual = (value === 'Type Manually');
                    if (!this.isManual && this.$refs.manualInput) {
                         this.$refs.manualInput.value = '';
                    }
                });

                if (this.locationValue && this.locations.includes(this.locationValue)) {
                    this.isManual = false;
                } else if (this.locationValue && this.locationValue !== 'Type Manually') {
                    this.isManual = true;
                    if (!this.locations.includes(this.locationValue)) {
                        this.locations.push(this.locationValue);
                    }
                    this.$nextTick(() => {
                        this.$refs.manualInput.value = this.locationValue;
                        this.locationValue = 'Type Manually';
                    });
                } else {
                    this.locationValue = 'Type Manually';
                    this.isManual = true;
                }
            }
        }));
    });
</script>