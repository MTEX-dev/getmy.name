<div
    x-data="{
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
        this.setTheme(this.theme);
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
            if (this.theme === 'system') {
                this.setTheme('system');
            }
        });
    }
}"
    x-init="init"
    class="inline-flex items-center rounded-md bg-gray-200/20 dark:bg-gray-700/20 p-1 backdrop-blur-md border border-white/10 dark:border-gray-800/10"
>
    <button
        @click="setTheme('light')"
        :class="{'bg-white/60 dark:bg-gray-900/60 text-gray-900 dark:text-gray-100 shadow-sm': theme === 'light', 'text-gray-700 dark:text-gray-300 hover:bg-white/30 dark:hover:bg-gray-800/30': theme !== 'light'}"
        class="px-3 py-1 rounded-md text-sm font-medium transition-all duration-200 ease-in-out"
    >
        Light
    </button>
    <button
        @click="setTheme('dark')"
        :class="{'bg-white/60 dark:bg-gray-900/60 text-gray-900 dark:text-gray-100 shadow-sm': theme === 'dark', 'text-gray-700 dark:text-gray-300 hover:bg-white/30 dark:hover:bg-gray-800/30': theme !== 'dark'}"
        class="px-3 py-1 rounded-md text-sm font-medium transition-all duration-200 ease-in-out"
    >
        Dark
    </button>
    <button
        @click="setTheme('system')"
        :class="{'bg-white/60 dark:bg-gray-900/60 text-gray-900 dark:text-gray-100 shadow-sm': theme === 'system', 'text-gray-700 dark:text-gray-300 hover:bg-white/30 dark:hover:bg-gray-800/30': theme !== 'system'}"
        class="px-3 py-1 rounded-md text-sm font-medium transition-all duration-200 ease-in-out"
    >
        System
    </button>
</div>

<script>
    (function () {
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