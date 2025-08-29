@props(['disabled' => false])
{{--
<input type="file" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'form-input file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100']) !!}>
--}}

<input 
    type="file" 
    {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge([
        'class' => '
            block w-full text-sm text-gray-900 dark:text-gray-300
            border border-gray-300 dark:border-gray-600 
            rounded-lg cursor-pointer
            bg-gray-50 dark:bg-gray-700
            file:mr-4 file:py-2 file:px-4
            file:rounded-md file:border-0
            file:text-sm file:font-semibold
            file:bg-violet-600 file:text-white
            hover:file:bg-violet-700
            focus:outline-none focus:ring focus:ring-violet-200 dark:focus:ring-violet-700
        '
    ]) !!}
>
