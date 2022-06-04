<?php

namespace App\Filament\Resources;

use App\Models\User;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\UserResource\Pages;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;

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
                TextColumn::make('last_name')->label('Name'),

                /*'last_name'
                'first_name'
                'middle_name'
                'phone'
                'phone_country'
                'date_of_birth'
                'gender'
                'account_number'
                'email'
                'phone_verified_at'
                'email_verified_at'
                'type'
                'address_line_1'
                'city'
                'state'
                'country'
                'status'*/

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

            ])
            ->filters([
                //
            ])
            ->prependActions([
                Action::make('verify')
                    ->tooltip(fn (User $record): string => "Verify User {$record->first_name}" )
                    ->action(fn (User $record) => $record->verifyAccount())
                    ->requiresConfirmation()
                    ->icon('heroicon-o-check')
                    ->color('success'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
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
