<div x-data="{
    theme: localStorage.getItem('theme') || 'system',
    init() {
        this.setTheme(this.theme);
        this.$watch('theme', value => this.setTheme(value));
    },
    setTheme(theme) {
        if (theme === 'system') {
            if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        } else if (theme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
        localStorage.setItem('theme', theme);
    },
    toggleTheme() {
        const themes = ['system', 'light', 'dark'];
        const currentIndex = themes.indexOf(this.theme);
        this.theme = themes[(currentIndex + 1) % themes.length];
        window.showToast('success', '{{ __('strings.messages.theme_change') }}', 750);
    }
}" class="relative inline-flex items-center justify-center ms-4">
    <button @click="toggleTheme()"
        class="w-10 aspect-square flex items-center justify-center
               rounded-xl cursor-pointer
               text-gray-500 dark:text-gray-400
               hover:bg-gray-200/30 dark:hover:bg-gray-700/30
               hover:text-gray-700 dark:hover:text-gray-300
               transition duration-200 ease-in-out focus:outline-none">
        <template x-if="theme === 'system'">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="1.5" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </template>

        <template x-if="theme === 'dark'">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="1.5" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
            </svg>
        </template>

        <template x-if="theme === 'light'">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="1.5" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
        </template>
    </button>
</div>