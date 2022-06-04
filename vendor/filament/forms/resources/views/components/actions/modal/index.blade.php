@php
    $action = $this->getMountedFormComponentAction();
@endphp

<form wire:submit.prevent="callMountedFormComponentAction">
    <x-forms::modal :id="\Illuminate\Support\Str::of(static::class)->replace('\\', '\\\\') . '-form-component-action'" :visible="filled($action)" :width="$action?->getModalWidth()" display-classes="block">
        @if ($action)
            @if ($action->isModalCentered())
                <x-slot name="heading">
                    {{ $action->getModalHeading() }}
                </x-slot>

                @if ($subheading = $action->getModalSubheading())
                    <x-slot name="subheading">
                        {{ $subheading }}
                    </x-slot>
                @endif
            @else
                <x-slot name="header">
                    <x-forms::modal.heading>
                        {{ $action->getModalHeading() }}
                    </x-forms::modal.heading>
                </x-slot>
            @endif

            {{ $this->getMountedFormComponentActionForm() }}

            <x-slot name="footer">
                <x-forms::modal.actions :full-width="$action->isModalCentered()">
                    @foreach ($action->getModalActions() as $modalAction)
                        {{ $modalAction }}
                    @endforeach
                </x-forms::modal.actions>
            </x-slot>
        @endif
    </x-forms::modal>
</form>
