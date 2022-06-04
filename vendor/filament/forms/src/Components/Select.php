<?php

namespace Filament\Forms\Components;

use Closure;
use Exception;
use Filament\Forms\Components\Actions\Action;
use Filament\Support\Concerns\HasExtraAlpineAttributes;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\HtmlString;

class Select extends Field
{
    use Concerns\HasAffixes;
    use Concerns\HasExtraInputAttributes;
    use Concerns\CanLimitItemsLength;
    use Concerns\HasOptions;
    use Concerns\HasPlaceholder;
    use HasExtraAlpineAttributes;

    protected string $view = 'forms::components.select';

    protected array | Closure | null $createOptionActionFormSchema = null;

    protected ?Closure $createOptionUsing = null;

    protected ?Closure $modifyCreateOptionActionUsing = null;

    protected bool | Closure $isMultiple = false;

    protected ?Closure $getOptionLabelUsing = null;

    protected ?Closure $getOptionLabelsUsing = null;

    protected ?Closure $getSearchResultsUsing = null;

    protected bool | Closure | null $isOptionDisabled = null;

    protected bool | Closure | null $isPlaceholderSelectionDisabled = false;

    protected bool | Closure $isSearchable = false;

    protected ?array $searchColumns = null;

    protected string | Closure | null $loadingMessage = null;

    protected string | HtmlString | Closure | null $noSearchResultsMessage = null;

    protected string | Closure | null $searchingMessage = null;

    protected string | HtmlString | Closure | null $searchPrompt = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->default(static fn (Select $component): ?array => $component->isMultiple() ? [] : null);

        $this->afterStateHydrated(static function (Select $component, $state): void {
            if (! $component->isMultiple()) {
                return;
            }

            if (is_array($state)) {
                return;
            }

            $component->state([]);
        });

        $this->getOptionLabelUsing(static function (Select $component, $value): ?string {
            if (array_key_exists($value, $options = $component->getOptions())) {
                return $options[$value];
            }

            return $value;
        });

        $this->getOptionLabelsUsing(static function (Select $component, array $values): array {
            $options = $component->getOptions();

            return collect($values)
                ->mapWithKeys(fn ($value) => [$value => $options[$value] ?? $value])
                ->toArray();
        });

        $this->loadingMessage(__('forms::components.select.loading_message'));
        $this->noSearchResultsMessage(__('forms::components.select.no_search_results_message'));
        $this->searchingMessage(__('forms::components.select.searching_message'));
        $this->searchPrompt(__('forms::components.select.search_prompt'));

        $this->placeholder(__('forms::components.select.placeholder'));
    }

    public function boolean(string $trueLabel = 'Yes', string $falseLabel = 'No'): static
    {
        $this->options([
            1 => $trueLabel,
            0 => $falseLabel,
        ]);

        return $this;
    }

    public function createOptionAction(?Closure $callback): static
    {
        $this->modifyCreateOptionActionUsing = $callback;

        return $this;
    }

    public function createOptionForm(array | Closure $schema): static
    {
        $this->createOptionActionFormSchema = $schema;

        $action = $this->getCreateOptionAction();

        $this->registerActions([
            'createOption' => $action,
        ]);

        $this->suffixAction($action);

        return $this;
    }

    public function createOptionUsing(Closure $callback): static
    {
        $this->createOptionUsing = $callback;

        return $this;
    }

    public function disableOptionWhen(bool | Closure $callback): static
    {
        $this->isOptionDisabled = $callback;

        return $this;
    }

    public function disablePlaceholderSelection(bool | Closure $condition = true): static
    {
        $this->isPlaceholderSelectionDisabled = $condition;

        return $this;
    }

    public function getCreateOptionUsing(): ?Closure
    {
        return $this->createOptionUsing;
    }

    public function getCreateOptionAction(): ?Action
    {
        if ($this->createOptionActionFormSchema === null) {
            return null;
        }

        $action = Action::make('createOption')
            ->form($this->getCreateOptionActionFormSchema())
            ->action(static function (Select $component, $data) {
                if (! $component->getCreateOptionUsing()) {
                    throw new Exception("Select field [{$component->getStatePath()}] must have a [createOptionUsing()] closure set.");
                }

                $createdOptionKey = $component->evaluate($component->getCreateOptionUsing(), [
                    'data' => $data,
                ]);

                $state = $component->isMultiple() ?
                    array_merge($component->getState(), [$createdOptionKey]) :
                    $createdOptionKey;

                $component->state($state);
            })
            ->icon('heroicon-o-plus')
            ->iconButton()
            ->modalHeading(__('forms::components.select.actions.create_option.modal.heading'))
            ->modalButton(__('forms::components.select.actions.create_option.modal.actions.create.label'))
            ->hidden(fn (Component $component): bool => $component->isDisabled());

        if ($this->modifyCreateOptionActionUsing) {
            $action = $this->evaluate($this->modifyCreateOptionActionUsing, [
                'action' => $action,
            ]);
        }

        return $action;
    }

    public function getCreateOptionActionFormSchema(): ?array
    {
        return $this->evaluate($this->createOptionActionFormSchema);
    }

    public function canCreateOption(): bool
    {
        return $this->getCreateOptionActionFormSchema() !== null;
    }

    public function getOptionLabelUsing(?Closure $callback): static
    {
        $this->getOptionLabelUsing = $callback;

        return $this;
    }

    public function getOptionLabelsUsing(?Closure $callback): static
    {
        $this->getOptionLabelsUsing = $callback;

        return $this;
    }

    public function getSearchResultsUsing(?Closure $callback): static
    {
        $this->getSearchResultsUsing = $callback;

        return $this;
    }

    public function searchable(bool | array | Closure $condition = true): static
    {
        if (is_array($condition)) {
            $this->isSearchable = true;
            $this->searchColumns = $condition;
        } else {
            $this->isSearchable = $condition;
            $this->searchColumns = null;
        }

        return $this;
    }

    public function multiple(bool | Closure $condition = true): static
    {
        $this->isMultiple = $condition;

        return $this;
    }

    public function loadingMessage(string | Closure | null $message): static
    {
        $this->loadingMessage = $message;

        return $this;
    }

    public function noSearchResultsMessage(string | HtmlString | Closure | null $message): static
    {
        $this->noSearchResultsMessage = $message;

        return $this;
    }

    public function searchingMessage(string | Closure | null $message): static
    {
        $this->searchingMessage = $message;

        return $this;
    }

    public function searchPrompt(string | HtmlString | Closure | null $message): static
    {
        $this->searchPrompt = $message;

        return $this;
    }

    public function getOptionLabel(): ?string
    {
        return $this->evaluate($this->getOptionLabelUsing, [
            'value' => $this->getState(),
        ]);
    }

    public function getOptionLabels(): array
    {
        $labels = $this->evaluate($this->getOptionLabelsUsing, [
            'values' => $this->getState(),
        ]);

        if ($labels instanceof Arrayable) {
            $labels = $labels->toArray();
        }

        return $labels;
    }

    public function getNoSearchResultsMessage(): string | HtmlString
    {
        return $this->evaluate($this->noSearchResultsMessage);
    }

    public function getSearchPrompt(): string | HtmlString
    {
        return $this->evaluate($this->searchPrompt);
    }

    public function getLoadingMessage(): string
    {
        return $this->evaluate($this->loadingMessage);
    }

    public function getSearchingMessage(): string
    {
        return $this->evaluate($this->searchingMessage);
    }

    public function getSearchColumns(): ?array
    {
        return $this->searchColumns;
    }

    public function getSearchResults(string $searchQuery): array
    {
        if (! $this->getSearchResultsUsing) {
            return [];
        }

        $results = $this->evaluate($this->getSearchResultsUsing, [
            'query' => $searchQuery,
            'searchQuery' => $searchQuery,
        ]);

        if ($results instanceof Arrayable) {
            $results = $results->toArray();
        }

        return $results;
    }

    public function isMultiple(): bool
    {
        return $this->evaluate($this->isMultiple);
    }

    public function isOptionDisabled($value, string $label): bool
    {
        if ($this->isOptionDisabled === null) {
            return false;
        }

        return (bool) $this->evaluate($this->isOptionDisabled, [
            'label' => $label,
            'value' => $value,
        ]);
    }

    public function isPlaceholderSelectionDisabled(): bool
    {
        return (bool) $this->evaluate($this->isPlaceholderSelectionDisabled);
    }

    public function isSearchable(): bool
    {
        return (bool) $this->evaluate($this->isSearchable);
    }

    public function hasDynamicSearchResults(): bool
    {
        return $this->getSearchResultsUsing instanceof Closure;
    }
}
