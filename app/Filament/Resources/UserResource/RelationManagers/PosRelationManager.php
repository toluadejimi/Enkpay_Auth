<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Resources\Form;
use Filament\Resources\Table;
use App\Filament\Resources\PosResource;
use Filament\Resources\RelationManagers\HasManyRelationManager;

class PosRelationManager extends HasManyRelationManager
{
    protected static string $relationship = 'allPos';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(PosResource::getFormSchema());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(PosResource::getTableColumns())
            ->filters([
                //
            ]);
    }
}
