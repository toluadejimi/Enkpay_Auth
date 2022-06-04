<?php

namespace App\Filament\Resources\RoleResource\RelationManagers;

use Illuminate\Support\Str;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\BelongsToManyRelationManager;

class PermissionsRelationManager extends BelongsToManyRelationManager
{
    protected static string $relationship = 'permissions';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('Name'))
                    ->placeholder(__('Name'))
                    ->required(),
                TextInput::make('guard_name')
                    ->disabled()
                    ->default(__('web')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('Name')),
                TextColumn::make('guard_name')
                    ->label(__('Guard'))
                    ->getStateUsing(fn ($record) => Str::ucfirst($record->name)),
                TextColumn::make('created_at')
                    ->getStateUsing(
                        fn ($record) => $record->created_at->diffForHumans()
                    ),
            ])
            ->filters([
                //
            ]);
    }
}
