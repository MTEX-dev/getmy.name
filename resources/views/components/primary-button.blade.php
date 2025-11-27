<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-getmyname-800 dark:bg-getmyname-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-getmyname-800 uppercase tracking-widest hover:bg-getmyname-700 dark:hover:bg-white focus:bg-getmyname-700 dark:focus:bg-white active:bg-getmyname-900 dark:active:bg-getmyname-300 focus:outline-none focus:ring-2 focus:ring-getmyname-500 focus:ring-offset-2 dark:focus:ring-offset-getmyname-800 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
