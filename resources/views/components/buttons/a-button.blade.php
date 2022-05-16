@props(['value'])
<a {{ $attributes->merge(['class' => 'focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-700 bg-blue-700 transition duration-150 ease-in-out hover:bg-blue-600 rounded text-white px-4 sm:px-10 py-2 sm:py-4 text-sm']) }}>
    {{ $value ?? $slot }}
</a>
