@props(['value'])
<x-buttons.button {{ $attributes->merge(['class' => 'text-white bg-green-600 hover:bg-green-700 focus:ring-green-500']) }}
>{{ $value ?? $slot }}</x-buttons.button>
