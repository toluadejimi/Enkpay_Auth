<x-filament::page>
    <div class="">
        <x-forms.form
            method="POST"
            class="space-y-4"
            wire:submit.prevent="assignPosToUser">
            {{ $this->form }}

            <div class="flex justify-start items-center">
                <x-buttons.primary
                    type="submit"
                    :value="__('Save')"
                />
            </div>
        </x-forms.form>
    </div>

</x-filament::page>
