<?php

namespace App\Filament\Resources;

use App\Models\User;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers\PosRelationManager;

class UserResource extends Resource
{
    protected static ?int $navigationSort = 1;

    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    // Update user info, Update Agent info, Delete Users

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(4)
                    ->schema([
                        Grid::make(6)->schema([
                            TextInput::make('first_name')
                                ->label(__('First Name'))
                                ->columnSpan(2),
                            TextInput::make('middle_name')
                                ->label(__('Middle Name'))
                                ->columnSpan(2),
                            TextInput::make('last_name')
                                ->label(__('Last Name'))
                                ->columnSpan(2),
                        ])->columnSpan(4),
                        TextInput::make('email')
                            ->label(__('Email address'))
                            ->columnSpan(4),
                        Grid::make(4)
                            ->schema([
                                DatePicker::make('date_of_birth')
                                    ->label(__('Date of birth'))
                                    ->columnSpan(2),
                                Select::make('gender')
                                    ->label(__('Gender'))
                                    ->columnSpan(2)
                        ])->columnSpan(4),
                        TextInput::make('address_line_1')
                            ->label(__('Address'))
                            ->columnSpan(4),
                        Grid::make(7)
                            ->schema([
                                    TextInput::make('city')
                                        ->label(__('City'))
                                        ->columnSpan(3),
                                    TextInput::make('state')
                                        ->label(__('State'))
                                        ->columnSpan(2),
                                    TextInput::make('Country')
                                        ->label(__('Country'))
                                        ->columnSpan(2),
                            ]
                        )
                    ]
                ),
                // 'phone', 'phone_country', 'account_number', 'type', 'status'
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('full_name')
                    ->label(__('Name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('account_number')
                    ->label(__('Account number'))
                    ->sortable(),
                TextColumn::make('gender')
                    ->label(__('Gender'))
                    ->sortable(),
                /*TextColumn::make('type')
                    ->label(__('Account type'))
                    ->sortable(),
                TextColumn::make('status')
                    ->label(__('Account status'))
                    ->sortable(),*/
            ])
            ->filters([
                //
            ])
            ->prependActions([
                Action::make('verify')
                    ->tooltip(fn (User $record): string => "Verify {$record->full_name}" )
                    ->action(fn (User $record) => $record->verifyAccount())
                    ->requiresConfirmation()
                    ->icon('heroicon-o-check')
                    ->color('success'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            PosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
