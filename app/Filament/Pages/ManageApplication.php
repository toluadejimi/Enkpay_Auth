<?php

namespace App\Filament\Pages;

use Filament\Pages\SettingsPage;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Placeholder;
use App\Models\Settings\ApplicationSettings;

class ManageApplication extends SettingsPage
{
    protected static ?int $navigationSort = 20;

    protected static ?string $navigationGroup = 'Settings';

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

                Card::make()
                    ->schema([
                        Grid::make(4)
                            ->schema([
                               Placeholder::make('commission_charges')
                                   ->label(__('COMMISSION CHARGES'))
                                   ->helperText(__('Commission Charges (%)')),
                               Card::make()
                                   ->schema([
                                           Placeholder::make('customer_charges_commission')
                                               ->label(__('COMMISSION CHARGES FOR CUSTOMER')),
                                           Grid::make(5)
                                               ->schema([
                                                       TextInput::make('customer_charges_commission_pos')
                                                           ->label(__('POS'))
                                                           ->suffix('%')
                                                           ->visible(fn ($get) => $get('pos'))
                                                           ->columnSpan(1),
                                                       TextInput::make('customer_charges_commission_transfer')
                                                           ->label(__('TRANSFER'))
                                                           ->suffix('%')
                                                           ->visible(fn ($get) => $get('transfer'))
                                                           ->columnSpan(1),
                                                       TextInput::make('customer_charges_commission_pay_bills')
                                                           ->label(__('PAY BILLS'))
                                                           ->suffix('%')
                                                           ->visible(fn ($get) => $get('pay_bills'))
                                                           ->columnSpan(1),
                                                       TextInput::make('customer_charges_commission_buy_airtime')
                                                           ->label(__('BUY AIRTIME'))
                                                           ->suffix('%')
                                                           ->visible(fn ($get) => $get('buy_airtime'))
                                                           ->columnSpan(1),
                                                       TextInput::make('customer_charges_commission_insurance')
                                                           ->label(__('INSURANCE'))
                                                           ->suffix('%')
                                                           ->visible(fn ($get) => $get('insurance'))
                                                           ->columnSpan(1),
                                                       TextInput::make('customer_charges_commission_exam_card')
                                                           ->label(__('EXAM CARD'))
                                                           ->suffix('%')
                                                           ->visible(fn ($get) => $get('exam_card'))
                                                           ->columnSpan(1),
                                                       TextInput::make('customer_charges_commission_buy_ticket')
                                                           ->label(__('BUY TICKET'))
                                                           ->suffix('%')
                                                           ->visible(fn ($get) => $get('buy_ticket'))
                                                           ->columnSpan(1),
                                                       TextInput::make('customer_charges_commission_exchange')
                                                           ->label(__('EXCHANGE'))
                                                           ->suffix('%')
                                                           ->visible(fn ($get) => $get('exchange'))
                                                           ->columnSpan(1),
                                                       TextInput::make('customer_charges_commission_data')
                                                           ->label(__('DATA'))
                                                           ->suffix('%')
                                                           ->visible(fn ($get) => $get('data'))
                                                           ->columnSpan(1),
                                                       TextInput::make('customer_charges_commission_flight')
                                                           ->label(__('FLIGHT'))
                                                           ->suffix('%')
                                                           ->visible(fn ($get) => $get('flight'))
                                                           ->columnSpan(1),
                                               ]
                                           )
                                   ]
                               ),

                                Card::make()
                                    ->schema([
                                            Placeholder::make('agent_charges_commission')
                                                ->label(__('COMMISSION CHARGES FOR AGENT')),
                                            Grid::make(5)
                                                ->schema([
                                                        TextInput::make('agent_charges_commission_pos')
                                                            ->label(__('POS'))
                                                            ->suffix('%')
                                                            ->visible(fn ($get) => $get('pos'))
                                                            ->columnSpan(1),
                                                        TextInput::make('agent_charges_commission_transfer')
                                                            ->label(__('TRANSFER'))
                                                            ->suffix('%')
                                                            ->visible(fn ($get) => $get('transfer'))
                                                            ->columnSpan(1),
                                                        TextInput::make('agent_charges_commission_pay_bills')
                                                            ->label(__('PAY BILLS'))
                                                            ->suffix('%')
                                                            ->visible(fn ($get) => $get('pay_bills'))
                                                            ->columnSpan(1),
                                                        TextInput::make('agent_charges_commission_buy_airtime')
                                                            ->label(__('BUY AIRTIME'))
                                                            ->suffix('%')
                                                            ->visible(fn ($get) => $get('buy_airtime'))
                                                            ->columnSpan(1),
                                                        TextInput::make('agent_charges_commission_insurance')
                                                            ->label(__('INSURANCE'))
                                                            ->suffix('%')
                                                            ->visible(fn ($get) => $get('insurance'))
                                                            ->columnSpan(1),
                                                        TextInput::make('agent_charges_commission_exam_card')
                                                            ->label(__('EXAM CARD'))
                                                            ->suffix('%')
                                                            ->visible(fn ($get) => $get('exam_card'))
                                                            ->columnSpan(1),
                                                        TextInput::make('agent_charges_commission_buy_ticket')
                                                            ->label(__('BUY TICKET'))
                                                            ->suffix('%')
                                                            ->visible(fn ($get) => $get('buy_ticket'))
                                                            ->columnSpan(1),
                                                        TextInput::make('agent_charges_commission_exchange')
                                                            ->label(__('EXCHANGE'))
                                                            ->suffix('%')
                                                            ->visible(fn ($get) => $get('exchange'))
                                                            ->columnSpan(1),
                                                        TextInput::make('agent_charges_commission_data')
                                                            ->label(__('DATA'))
                                                            ->suffix('%')
                                                            ->visible(fn ($get) => $get('data'))
                                                            ->columnSpan(1),
                                                        TextInput::make('agent_charges_commission_flight')
                                                            ->label(__('FLIGHT'))
                                                            ->suffix('%')
                                                            ->visible(fn ($get) => $get('flight'))
                                                            ->columnSpan(1),
                                                    ]
                                                )
                                            ]
                                        )
                            ]
                        )
                    ]
                )
            ])
        ];
    }
}
