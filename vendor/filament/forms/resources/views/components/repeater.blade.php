<x-dynamic-component
    :component="$getFieldWrapperView()"
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>
    @php
        $containers = $getChildComponentContainers();

        $isItemCreationDisabled = $isItemCreationDisabled();
        $isItemDeletionDisabled = $isItemDeletionDisabled();
        $isItemMovementDisabled = $isItemMovementDisabled();
    @endphp

    @if (count($containers) > 1)
        <div class="space-x-2 rtl:space-x-reverse" x-data="{}">
            <x-forms::link
                x-on:click="$dispatch('repeater-collapse', '{{ $getStatePath() }}')"
                tag="button"
                size="sm"
            >
                {{ __('forms::components.repeater.buttons.collapse_all.label') }}
            </x-forms::link>

            <x-forms::link
                x-on:click="$dispatch('repeater-expand', '{{ $getStatePath() }}')"
                tag="button"
                size="sm"
            >
                {{ __('forms::components.repeater.buttons.expand_all.label') }}
            </x-forms::link>
        </div>
    @endif

    <div {{ $attributes->merge($getExtraAttributes())->class([
        'space-y-6 rounded-xl filament-forms-repeater-component',
        'bg-gray-50 p-6' => $isInset(),
        'dark:bg-gray-500/10' => $isInset() && config('forms.dark_mode'),
    ]) }}>
        @if (count($containers))
            <ul
                class="space-y-6"
                wire:sortable
                wire:end.stop="dispatchFormEvent('repeater::moveItems', '{{ $getStatePath() }}', $event.target.sortable.toArray())"
            >
                @foreach ($containers as $uuid => $item)
                    <li
                        x-data="{ isCollapsed: false }"
                        x-on:repeater-collapse.window="$event.detail === '{{ $getStatePath() }}' && (isCollapsed = true)"
                        x-on:repeater-expand.window="$event.detail === '{{ $getStatePath() }}' && (isCollapsed = false)"
                        wire:key="{{ $item->getStatePath() }}"
                        wire:sortable.item="{{ $uuid }}"
                        @class([
                            'bg-white border border-gray-300 shadow-sm rounded-xl relative',
                            'dark:bg-gray-800 dark:border-gray-600' => config('forms.dark_mode'),
                        ])
                    >
                        <header @class([
                            'flex items-center h-10 overflow-hidden border-b bg-gray-50 rounded-t-xl',
                            'dark:bg-gray-800 dark:border-gray-700' => config('forms.dark_mode'),
                        ])>
                            @unless ($isItemMovementDisabled)
                                <button
                                    wire:sortable.handle
                                    wire:keydown.prevent.arrow-up="dispatchFormEvent('repeater::moveItemUp', '{{ $getStatePath() }}', '{{ $uuid }}')"
                                    wire:keydown.prevent.arrow-down="dispatchFormEvent('repeater::moveItemDown', '{{ $getStatePath() }}', '{{ $uuid }}')"
                                    type="button"
                                    @class([
                                        'flex items-center justify-center flex-none w-10 h-10 text-gray-400 border-r transition hover:text-gray-300',
                                        'dark:text-gray-400 dark:border-gray-700 dark:hover:text-gray-500' => config('forms.dark_mode'),
                                    ])
                                >
                                    <span class="sr-only">
                                        {{ __('forms::components.repeater.buttons.move_item_down.label') }}
                                    </span>

                                    <x-heroicon-s-switch-vertical class="w-4 h-4"/>
                                </button>
                            @endunless

                            <div class="flex-1"></div>

                            <ul class="flex divide-x dark:divide-gray-700">
                                @unless ($isItemDeletionDisabled)
                                    <li>
                                        <button
                                            wire:click="dispatchFormEvent('repeater::deleteItem', '{{ $getStatePath() }}', '{{ $uuid }}')"
                                            type="button"
                                            @class([
                                                'flex items-center justify-center flex-none w-10 h-10 text-danger-600 transition hover:text-danger-500',
                                                'dark:text-danger-500 dark:hover:text-danger-400' => config('forms.dark_mode'),
                                            ])
                                        >
                                            <span class="sr-only">
                                                {{ __('forms::components.repeater.buttons.delete_item.label') }}
                                            </span>

                                            <x-heroicon-s-trash class="w-4 h-4"/>
                                        </button>
                                    </li>
                                @endunless

                                <li>
                                    <button
                                        x-on:click="isCollapsed = !isCollapsed"
                                        type="button"
                                        @class([
                                            'flex items-center justify-center flex-none w-10 h-10 text-gray-400 transition hover:text-gray-300',
                                            'dark:text-gray-400 dark:hover:text-gray-500' => config('forms.dark_mode'),
                                        ])
                                    >
                                        <x-heroicon-s-minus-sm class="w-4 h-4" x-show="! isCollapsed"/>

                                        <span class="sr-only" x-show="! isCollapsed">
                                            {{ __('forms::components.repeater.buttons.collapse_item.label') }}
                                        </span>

                                        <x-heroicon-s-plus-sm class="w-4 h-4" x-show="isCollapsed" x-cloak/>

                                        <span class="sr-only" x-show="isCollapsed" x-cloak>
                                            {{ __('forms::components.repeater.buttons.expand_item.label') }}
                                        </span>
                                    </button>
                                </li>
                            </ul>
                        </header>

                        <div class="p-6" x-show="! isCollapsed">
                            {{ $item }}
                        </div>

                        <div class="p-2 text-xs text-center text-gray-400" x-show="isCollapsed" x-cloak>
                            {{ __('forms::components.repeater.collapsed') }}
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif

        @if (! $isItemCreationDisabled)
            <div class="relative flex justify-center">
                <x-forms::button
                    :wire:click="'dispatchFormEvent(\'repeater::createItem\', \'' . $getStatePath() . '\')'"
                    size="sm"
                    type="button"
                >
                    {{ $getCreateItemButtonLabel() }}
                </x-forms::button>
            </div>
        @endif
    </div>
</x-dynamic-component>
