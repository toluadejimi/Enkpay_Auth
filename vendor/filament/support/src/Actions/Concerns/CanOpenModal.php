<?php

namespace Filament\Support\Actions\Concerns;

use Closure;
use Filament\Support\Actions\Modal\Actions\Action as ModalAction;

trait CanOpenModal
{
    protected bool | Closure | null $isModalCentered = null;

    protected array | Closure | null $modalActions = null;

    protected string | Closure | null $modalButtonLabel = null;

    protected string | Closure | null $modalHeading = null;

    protected string | Closure | null $modalSubheading = null;

    protected string | Closure | null $modalWidth = null;

    public function centerModal(bool | Closure | null $condition = true): static
    {
        $this->isModalCentered = $condition;

        return $this;
    }

    public function modalActions(array | Closure | null $actions = null): static
    {
        $this->modalActions = $actions;

        return $this;
    }

    public function modalButton(string | Closure | null $label = null): static
    {
        $this->modalButtonLabel = $label;

        return $this;
    }

    public function modalHeading(string | Closure | null $heading = null): static
    {
        $this->modalHeading = $heading;

        return $this;
    }

    public function modalSubheading(string | Closure | null $subheading = null): static
    {
        $this->modalSubheading = $subheading;

        return $this;
    }

    public function modalWidth(string | Closure | null $width = null): static
    {
        $this->modalWidth = $width;

        return $this;
    }

    abstract protected function getLivewireSubmitActionName(): string;

    public function getModalActions(): array
    {
        if ($this->modalActions !== null) {
            return $this->evaluate($this->modalActions);
        }

        $actions = [
            static::makeModalAction('submit')
                ->label($this->getModalButtonLabel())
                ->submit($this->getLivewireSubmitActionName())
                ->color($this->getColor()),
            static::makeModalAction('cancel')
                ->label(__('filament-support::actions.modal.buttons.cancel.label'))
                ->cancel()
                ->color('secondary'),
        ];

        if ($this->isModalCentered()) {
            $actions = array_reverse($actions);
        }

        return $actions;
    }

    public function getModalButtonLabel(): string
    {
        if (filled($this->modalButtonLabel)) {
            return $this->evaluate($this->modalButtonLabel);
        }

        if ($this->isConfirmationRequired()) {
            return __('filament-support::actions.modal.buttons.confirm.label');
        }

        return __('filament-support::actions.modal.buttons.submit.label');
    }

    public function getModalHeading(): string
    {
        return $this->evaluate($this->modalHeading) ?? $this->getLabel();
    }

    public function getModalSubheading(): ?string
    {
        if (filled($this->modalSubheading)) {
            return $this->evaluate($this->modalSubheading);
        }

        if ($this->isConfirmationRequired()) {
            return __('filament-support::actions.modal.requires_confirmation_subheading');
        }

        return null;
    }

    public function getModalWidth(): string
    {
        if (filled($this->modalWidth)) {
            return $this->evaluate($this->modalWidth);
        }

        if ($this->isConfirmationRequired()) {
            return 'sm';
        }

        return '4xl';
    }

    public function isModalCentered(): bool
    {
        if ($this->isModalCentered !== null) {
            return $this->evaluate($this->isModalCentered);
        }

        if (in_array($this->getModalWidth(), ['xs', 'sm'])) {
            return true;
        }

        return $this->isConfirmationRequired();
    }

    public function shouldOpenModal(): bool
    {
        return $this->isConfirmationRequired() || $this->hasFormSchema();
    }

    protected static function getModalActionClass(): string
    {
        return ModalAction::class;
    }

    public static function makeModalAction(string $name): ModalAction
    {
        return static::getModalActionClass()::make($name);
    }
}
