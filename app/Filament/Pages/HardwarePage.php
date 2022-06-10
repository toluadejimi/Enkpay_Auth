<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\DTOs\POSDeviceData;
use App\Enums\DeviceTypeEnum;
use Filament\Facades\Filament;
use App\Enums\DeviceStatusEnum;
use App\Actions\CreateDeviceAction;
use Filament\Forms\Components\Grid;
use Illuminate\Http\RedirectResponse;
use Filament\Forms\Components\Select;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Components\TextInput;
use App\Filament\Widgets\HardwareStatsOverview;

/** @property ComponentContainer $form */
class HardwarePage extends Page
{
    public ?string $status = '';

    public ?string $device_id = '';

    public ?string $device_type = '';

    protected static ?int $navigationSort = 2;

    protected static ?string $pollingInterval = '10s';

    protected static ?string $navigationGroup = 'Device';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.hardware-page';

    protected function getHeaderWidgets(): array
    {
        return [
            HardwareStatsOverview::class
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            Grid::make(3)
                ->schema([
                    TextInput::make('device_id')
                        ->label(__('DEVICE ID'))
                        ->placeholder(__('DEVICE ID'))
                        ->disableAutocomplete()
                        ->columnSpan(1),
                    Select::make('device_type')
                        ->label(__('DEVICE TYPE'))
                        ->options(DeviceTypeEnum::toArray())
                        ->required()
                        ->placeholder(__('Select device type'))
                        ->columnSpan(1),
                    Select::make('status')
                        ->label(__('STATUS'))
                        ->options(DeviceStatusEnum::toArray())
                        ->required()
                        ->placeholder(__('Select status'))
                        ->columnSpan(1),
                ])
        ];
    }

    public function createDevice(): RedirectResponse
    {
        $device = CreateDeviceAction::execute(
            POSDeviceData::fromArray(
                $this->form->getState()
            )
        );

        ($device->exists)
            ? $this->successfulDeviceCreation()
            : $this->unSuccessfulDeviceCreation();

        return redirect()->back();
    }

    protected function successfulDeviceCreation()
    {
        $this->form->fill();

        Filament::notify(
            'success',
            __('Device successfully added.')
        );
    }

    protected function unSuccessfulDeviceCreation()
    {
        Filament::notify(
            'danger',
            __('Unable to add device, Please try again later.')
        );
    }
}
