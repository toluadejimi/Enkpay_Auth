<div class="bg-white dark:bg-gray-800 py-8 px-4 shadow sm:rounded-lg">
    <x-forms.form
        method="POST"
        class="space-y-6"
        wire:submit.prevent="authenticate">
        {{ $this->form }}

        <div class="flex justify-center items-center">
            <x-buttons.primary
                type="submit"
                class="w-full"
                :value="__('Sign in')"
            />
        </div>
    </x-forms.form>
</div>
