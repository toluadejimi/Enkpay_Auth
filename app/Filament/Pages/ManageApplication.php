<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\Card;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use App\Models\Settings\ApplicationSettings;

class ManageApplication extends SettingsPage
{
    protected static ?int $navigationSort = 10;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static string $settings = ApplicationSettings::class;

    protected function getFormSchema(): array
    {
        return [
            Grid::make()->schema([
                Placeholder::make('application_settings')
                    ->label(__('APPLICATION SETTINGS'))
                    ->helperText(__('Enable/disable application settings')),

                Card::make()
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                    TextInput::make('bills_commission')
                                        ->label(__('Bills Commission'))
                                        ->placeholder(__('Bills Commission'))
                                        ->columnSpan(2),
                                    TextInput::make('transfer_commission')
                                        ->label(__('Transfer Commission'))
                                        ->placeholder(__('Transfer Commission'))
                                        ->columnSpan(2)
                            ]
                        ),
                        Grid::make(4)
                            ->schema([
                                    Card::make()
                                        ->schema([
                                            Checkbox::make('pos')
                                                ->label(__('Enable POS')),
                                            Checkbox::make('flight')
                                                ->label(__('Enable flight bookings')),
                                            Checkbox::make('transfer')
                                                ->label(__('Enable transfer')),
                                            Checkbox::make('exam_card')
                                                ->label(__('Enable card purchase')),
                                            Checkbox::make('pay_bills')
                                                ->label(__('Enable bills payment')),
                                        ]
                                    )->columnSpan(2),

                                    Card::make()
                                        ->schema([
                                            Checkbox::make('data')
                                                ->label(__('Enable data')),
                                            Checkbox::make('exchange')
                                                ->label(__('Enable exchange')),
                                            Checkbox::make('buy_ticket')
                                                ->label(__('Enable buying of ticket')),
                                            Checkbox::make('insurance')
                                                ->label(__('Enable insurance')),
                                            Checkbox::make('buy_airtime')
                                                ->label(__('Enable buying of airtime')),
                                        ]
                                    )->columnSpan(2),
                            ]
                        ),
                    ]
                ),
            ])
        ];
    }
}
