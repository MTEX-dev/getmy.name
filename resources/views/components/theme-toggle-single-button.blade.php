<div x-data="{
    theme: localStorage.getItem('theme') || 'system',
    nextTheme() {
        const themes = ['system', 'light', 'dark'];
        const currentIndex = themes.indexOf(this.theme);
        const nextIndex = (currentIndex + 1) % themes.length;
        this.setTheme(themes[nextIndex]);
    },
    setTheme(newTheme) {
        this.theme = newTheme;
        if (newTheme === 'system') {
            localStorage.removeItem('theme');
            document.documentElement.classList.toggle('dark', window.matchMedia('(prefers-color-scheme: dark)').matches);
        } else {
            localStorage.setItem('theme', newTheme);
            document.documentElement.classList.toggle('dark', newTheme === 'dark');
        }
    },
    currentIcon() {
        return this.theme === 'dark' ? 'bi-moon-fill'
             : this.theme === 'light' ? 'bi-sun-fill'
             : 'bi-laptop';
    },
    init() {
        this.setTheme(this.theme);
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
            if (this.theme === 'system') this.setTheme('system');
        });
    }
}" x-init="init" class="inline-flex">
    <button
        @click="nextTheme"
        type="button"
        class="flex items-center justify-center 
               w-12 h-12 rounded-full
               bg-gray-100 dark:bg-gray-700
               text-gray-600 dark:text-gray-300
               hover:bg-gray-200 dark:hover:bg-gray-600
               focus:outline-none focus:ring-2 focus:ring-offset-2 
               focus:ring-indigo-500 focus:ring-offset-gray-50 dark:focus:ring-offset-gray-800
               transition-colors duration-300 ease-in-out shadow-md"
        aria-label="Toggle theme"
    >
        <i :class="currentIcon()" 
           class="text-xl transform transition-all duration-500 ease-in-out"
           x-transition:enter="opacity-0 scale-75 rotate-90"
           x-transition:enter-end="opacity-100 scale-100 rotate-0"
           x-transition:leave="opacity-100 scale-100 rotate-0"
           x-transition:leave-end="opacity-0 scale-75 -rotate-90">
        </i>
    </button>
</div>

<script>
    (() => {
        const storedTheme = localStorage.getItem('theme');
        if (storedTheme === 'dark') {
            document.documentElement.classList.add('dark');
        } else if (storedTheme === 'light') {
            document.documentElement.classList.remove('dark');
        } else {
            document.documentElement.classList.toggle(
                'dark',
                window.matchMedia('(prefers-color-scheme: dark)').matches
            );
        }
    })();
</script>
