@props([
    'disabled' => false,
])

<input 
    type="file"
    {{ $disabled ? 'disabled' : '' }}
    {{ $attributes->merge([
        'class' => 'block w-full text-sm
                    border border-gray-300 dark:border-gray-700
                    rounded-md shadow-sm
                    bg-white text-gray-900 dark:bg-gray-900 dark:text-gray-300
                    focus:border-getmyname-500 dark:focus:border-getmyname-600
                    focus:ring-getmyname-500 dark:focus:ring-getmyname-600
                    file:mr-4 file:py-2 file:px-4 
                    file:rounded-md file:border-0
                    file:font-semibold file:uppercase file:text-xs
                    file:bg-gray-800 file:text-white
                    dark:file:bg-gray-200 dark:file:text-gray-800
                    hover:file:bg-gray-700 dark:hover:file:bg-white
                    transition ease-in-out duration-150'
    ]) }}
>
