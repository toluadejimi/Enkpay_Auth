@captureSlots([
    'actions',
    'footer',
    'header',
    'heading',
    'subheading',
])

<x-filament-support::modal
    :attributes="\Filament\Support\prepare_inherited_attributes($attributes)->merge($slots)"
    :dark-mode="config('tables.dark_mode')"
    heading-component="tables::modal.heading"
    hr-component="tables::hr"
    subheading-component="tables::modal.subheading"
>
    {{ $slot }}
</x-filament-support::modal>
