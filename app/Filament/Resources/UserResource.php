<?php

namespace App\Filament\Resources;

use App\Models\User;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\UserResource\Pages;

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
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
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
