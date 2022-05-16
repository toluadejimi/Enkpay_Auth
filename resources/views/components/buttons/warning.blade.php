@props(['value'])
<x-buttons.button {{ $attributes->merge(['class' => 'text-white bg-orange-600 hover:bg-orange-700 focus:ring-orange-500']) }}
>{{ $value ?? $slot }}</x-buttons.button>
