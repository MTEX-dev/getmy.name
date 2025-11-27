<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-gimysite-800 dark:bg-gimysite-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gimysite-800 uppercase tracking-widest hover:bg-gimysite-700 dark:hover:bg-white focus:bg-gimysite-700 dark:focus:bg-white active:bg-gimysite-900 dark:active:bg-gimysite-300 focus:outline-none focus:ring-2 focus:ring-gimysite-500 focus:ring-offset-2 dark:focus:ring-offset-gimysite-800 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
