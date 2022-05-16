@props(['value'])
<x-buttons.button {{ $attributes->merge(['class' => 'text-white bg-blue-600 hover:bg-blue-700 focus:ring-blue-500']) }}
>{{ $value ?? $slot }}</x-buttons.button>
