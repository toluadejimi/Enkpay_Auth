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
                x-on:click="$dispatch('builder-collapse', '{{ $getStatePath() }}')"
                tag="button"
                size="sm"
            >
                {{ __('forms::components.builder.buttons.collapse_all.label') }}
            </x-forms::link>

            <x-forms::link
                x-on:click="$dispatch('builder-expand', '{{ $getStatePath() }}')"
                tag="button"
                size="sm"
            >
                {{ __('forms::components.builder.buttons.expand_all.label') }}
            </x-forms::link>
        </div>
    @endif

    <div {{ $attributes->merge($getExtraAttributes())->class([
        'space-y-6 rounded-xl filament-forms-builder-component',
        'bg-gray-50 p-6' => $isInset(),
        'dark:bg-gray-500/10' => $isInset() && config('forms.dark_mode'),
    ]) }}>
        @if (count($containers))
            <ul
                class="space-y-12"
                wire:sortable
                wire:end.stop="dispatchFormEvent('builder::moveItems', '{{ $getStatePath() }}', $event.target.sortable.toArray())"
            >
                @php
                    $hasBlockLabels = $hasBlockLabels();
                @endphp

                @foreach ($containers as $uuid => $item)
                    <li
                        x-data="{
                            isCreateButtonDropdownOpen: false,
                            isCreateButtonVisible: false,
                            isCollapsed: false,
                        }"
                        x-on:builder-collapse.window="$event.detail === '{{ $getStatePath() }}' && (isCollapsed = true)"
                        x-on:builder-expand.window="$event.detail === '{{ $getStatePath() }}' && (isCollapsed = false)"
                        x-on:click="isCreateButtonVisible = true"
                        x-on:mouseenter="isCreateButtonVisible = true"
                        x-on:click.away="isCreateButtonVisible = false"
                        x-on:mouseleave="isCreateButtonVisible = false"
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
                                    wire:keydown.prevent.arrow-up="dispatchFormEvent('builder::moveItemUp', '{{ $getStatePath() }}', '{{ $uuid }}')"
                                    wire:keydown.prevent.arrow-down="dispatchFormEvent('builder::moveItemDown', '{{ $getStatePath() }}', '{{ $uuid }}')"
                                    type="button"
                                    @class([
                                        'flex items-center justify-center flex-none w-10 h-10 text-gray-400 border-r transition hover:text-gray-300',
                                        'dark:text-gray-400 dark:border-gray-700 dark:hover:text-gray-500' => config('forms.dark_mode'),
                                    ])
                                >
                                    <span class="sr-only">
                                        {{ __('forms::components.builder.buttons.move_item_down.label') }}
                                    </span>

                                    <x-heroicon-s-switch-vertical class="w-4 h-4"/>
                                </button>
                            @endunless

                            @if ($hasBlockLabels)
                                <p @class([
                                    'flex-none px-4 text-xs font-medium text-gray-600 truncate',
                                    'dark:text-gray-400' => config('forms.dark_mode'),
                                ])>
                                    {{ $item->getParentComponent()->getLabel() }}

                                    <small class="font-mono">{{ $loop->iteration }}</small>
                                </p>
                            @endif

                            <div class="flex-1"></div>

                            <ul class="flex divide-x dark:divide-gray-700">
                                @unless ($isItemDeletionDisabled)
                                    <li>
                                        <button
                                            wire:click="dispatchFormEvent('builder::deleteItem', '{{ $getStatePath() }}', '{{ $uuid }}')"
                                            type="button"
                                            @class([
                                                'flex items-center justify-center flex-none w-10 h-10 text-danger-600 transition hover:text-danger-500',
                                                'dark:text-danger-500 dark:hover:text-danger-400' => config('forms.dark_mode'),
                                            ])
                                        >
                                            <span class="sr-only">
                                                {{ __('forms::components.builder.buttons.delete_item.label') }}
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
                                            {{ __('forms::components.builder.buttons.collapse_item.label') }}
                                        </span>

                                        <x-heroicon-s-plus-sm class="w-4 h-4" x-show="isCollapsed" x-cloak/>

                                        <span class="sr-only" x-show="isCollapsed" x-cloak>
                                            {{ __('forms::components.builder.buttons.expand_item.label') }}
                                        </span>
                                    </button>
                                </li>
                            </ul>
                        </header>

                        <div class="p-6" x-show="! isCollapsed">
                            {{ $item }}
                        </div>

                        <div class="p-2 text-xs text-center text-gray-400" x-show="isCollapsed" x-cloak>
                            {{ __('forms::components.builder.collapsed') }}
                        </div>

                        @if ((! $loop->last) && (! $isItemCreationDisabled) && (! $isItemMovementDisabled))
                            <div
                                x-show="isCreateButtonVisible || isCreateButtonDropdownOpen"
                                x-transition
                                class="absolute inset-x-0 bottom-0 z-10 flex items-center justify-center h-12 -mb-12"
                            >
                                <div class="relative flex justify-center">
                                    <x-forms::icon-button
                                        :label="$getCreateItemBetweenButtonLabel()"
                                        icon="heroicon-o-plus"
                                        x-on:click="isCreateButtonDropdownOpen = true"
                                        type="button"
                                    />

                                    <x-forms::builder.block-picker
                                        :blocks="$getBlocks()"
                                        :create-after-item="$uuid"
                                        :state-path="$getStatePath()"
                                    />
                                </div>
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif

        @if (! $isItemCreationDisabled)
            <div x-data="{ isCreateButtonDropdownOpen: false }" class="relative flex justify-center">
                <x-forms::button
                    size="sm"
                    x-on:click="isCreateButtonDropdownOpen = true"
                    type="button"
                >
                    {{ $getCreateItemButtonLabel() }}
                </x-forms::button>

                <x-forms::builder.block-picker
                    :blocks="$getBlocks()"
                    :state-path="$getStatePath()"
                />
            </div>
        @endif
    </div>
</x-dynamic-component>
