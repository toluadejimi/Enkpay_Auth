<x-filament::page>
    <div class="">
        <x-forms.form method="POST" class="space-y-4" wire:submit.prevent="sendMessage">
            {{ $this->form }}

            <div class="flex justify-start items-center">
                <x-buttons.primary
                    type="submit"
                    :value="__('Send')"
                />
            </div>
        </x-forms.form>
    </div>
</x-filament::page>
