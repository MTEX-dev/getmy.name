@props(['disabled' => false, 'id', 'name', 'value' => ''])

<textarea
    id="{{ $id }}"
    name="{{ $name }}"
    {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-getmyname-500 dark:focus:border-getmyname-600 focus:ring-getmyname-500 dark:focus:ring-getmyname-600 rounded-md shadow-sm']) !!}
>{{ old($name, $value) }}</textarea>