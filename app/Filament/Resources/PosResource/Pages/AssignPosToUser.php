<?php

namespace App\Filament\Resources\PosResource\Pages;

use App\Models\Pos;
use App\Models\User;
use Filament\Facades\Filament;
use App\DTOs\POSDeviceAssignData;
use Filament\Resources\Pages\Page;
use Filament\Forms\Components\Grid;
use App\Actions\AssignDeviceAction;
use Filament\Forms\Components\Select;
use Illuminate\Http\RedirectResponse;
use Filament\Forms\ComponentContainer;
use App\Filament\Resources\PosResource;
use Filament\Forms\Components\TextInput;

/** @property ComponentContainer $form */
class AssignPosToUser extends Page
{
    public string $agent = '';

    public string $device = '';

    public string $location = '';

    protected static string $resource = PosResource::class;

    protected static string $view = 'filament.resources.pos-resource.pages.assign-pos-to-user';

    protected function getFormSchema(): array
    {
        return [
            Grid::make(4)
                ->schema([
                        Select::make('agent')
                            ->label(__('SELECT AGENT'))
                            ->searchable()
                            ->getSearchResultsUsing(fn (string $searchQuery) => User::query()->where('email', 'like', "%{$searchQuery}%")->limit(50)->pluck('name', 'id'))
                            ->getOptionLabelUsing(fn ($value): ?string => User::query()->find($value)?->email)
                            ->options(
                                User::query()
                                    ->onlyAgent()
                                    ->get()
                                    ->pluck('email', 'id')
                            )
                            ->placeholder(__('Select user to assign to:'))
                            ->required()
                            ->columnSpan(2),
                        Select::make('device')
                            ->label(__('SELECT DEVICE'))
                            ->searchable()
                            ->options(Pos::all()->pluck('device_id', 'id'))
                            ->placeholder(__('DEVICE ID'))
                            ->columnSpan(2),
                        TextInput::make('location')
                            ->label(__('LOCATION (STATE)'))
                            ->required()
                            ->columnSpan(4),
                    ]
                )
        ];
    }

    public function assignPosToUser(): RedirectResponse
    {
        $status = AssignDeviceAction::execute(
            POSDeviceAssignData::fromArray(
                $this->form->getState()
            )
        );

        ($status)
            ? $this->successfulAssignedDevice()
            : $this->unableToAssignDevice();

        return redirect()->back();
    }

    protected function successfulAssignedDevice()
    {
        Filament::notify(
            'success',
            __('Device successfully assigned.')
        );
    }

    protected function unableToAssignDevice()
    {
        Filament::notify(
            'danger',
            __('Unable to assign device, Please try again later.')
        );
    }
}
