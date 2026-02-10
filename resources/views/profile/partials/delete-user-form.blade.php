<section class="space-y-6">
    <!-- Header with Warning Styling -->
    <header class="flex items-start gap-4 border-b border-gray-100 dark:border-gray-700 pb-6 mb-8">
        <div class="p-3 bg-red-50 dark:bg-red-900/20 rounded-2xl text-red-600 dark:text-red-400 shadow-sm ring-1 ring-red-500/10">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                {{ __('profile.delete_account') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('profile.delete_account_info_1') }}
            </p>
        </div>
    </header>

    <!-- Content / Trigger Area -->
    <div class="bg-red-50/50 dark:bg-red-900/10 border border-red-100 dark:border-red-900/30 rounded-2xl p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="text-sm text-red-800 dark:text-red-200">
            <span class="font-bold">{{ __('Warning:') }}</span> 
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </div>
        
        <x-danger-button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="whitespace-nowrap flex-shrink-0"
        >
            {{ __('profile.delete_account') }}
        </x-danger-button>
    </div>

    <!-- Confirmation Modal -->
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 dark:bg-red-900/30 rounded-full mb-4">
                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>

            <div class="text-center mb-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                    {{ __('profile.delete_account_confirm') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('profile.delete_account_info_2') }}
                </p>
            </div>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('strings.password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full"
                    placeholder="{{ __('strings.password') }}"
                    @keyup.enter="$dispatch('submit')"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('profile.cancel') }}
                </x-secondary-button>

                <x-danger-button>
                    {{ __('profile.delete_account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>