<button {{ $attributes->merge(['class' => 'flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2']) }}>
    {{ $slot ?? null }}
</button>
