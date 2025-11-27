@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-gimysite-500 dark:focus:border-gimysite-600 focus:ring-gimysite-500 dark:focus:ring-gimysite-600 rounded-md shadow-sm']) }}>
