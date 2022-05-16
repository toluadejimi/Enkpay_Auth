@props(['value'])
<x-buttons.button {{ $attributes->merge(['class' => 'text-white bg-red-600 hover:bg-red-700 focus:ring-red-500']) }}
>{{ $value ?? $slot }}</x-buttons.button>
