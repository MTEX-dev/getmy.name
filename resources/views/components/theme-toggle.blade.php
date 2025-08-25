<div x-data="{
    theme: localStorage.getItem('theme') || 'system',
    setTheme(newTheme) {
        this.theme = newTheme;
        if (newTheme === 'system') {
            localStorage.removeItem('theme');
            if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        } else {
            localStorage.setItem('theme', newTheme);
            if (newTheme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
    },
    init() {
        // Set initial theme based on localStorage or system preference
        this.setTheme(this.theme);

        // Listen for system theme changes if 'system' is active
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
            if (this.theme === 'system') {
                this.setTheme('system'); // Re-evaluate system theme
            }
        });
    }
}" x-init="init" class="inline-flex items-center rounded-md bg-gray-200 dark:bg-gray-700 p-1">
    <button
        @click="setTheme('light')"
        :class="{'bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow': theme === 'light', 'text-gray-700 dark:text-gray-300': theme !== 'light'}"
        class="px-3 py-1 rounded-md text-sm font-medium transition-colors duration-200 ease-in-out"
    >
        Light
    </button>
    <button
        @click="setTheme('dark')"
        :class="{'bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow': theme === 'dark', 'text-gray-700 dark:text-gray-300': theme !== 'dark'}"
        class="px-3 py-1 rounded-md text-sm font-medium transition-colors duration-200 ease-in-out"
    >
        Dark
    </button>
    <button
        @click="setTheme('system')"
        :class="{'bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow': theme === 'system', 'text-gray-700 dark:text-gray-300': theme !== 'system'}"
        class="px-3 py-1 rounded-md text-sm font-medium transition-colors duration-200 ease-in-out"
    >
        System
    </button>
</div>

<script>
    (function() {
        const storedTheme = localStorage.getItem('theme');
        if (storedTheme === 'dark') {
            document.documentElement.classList.add('dark');
        } else if (storedTheme === 'light') {
            document.documentElement.classList.remove('dark');
        } else {
            if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
    })();
</script>