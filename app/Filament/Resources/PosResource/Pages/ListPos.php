<?php

namespace App\Filament\Resources\PosResource\Pages;

use Filament\Pages\Actions\Action;
use App\Filament\Resources\PosResource;
use Filament\Resources\Pages\ListRecords;

class ListPos extends ListRecords
{
    protected static string $resource = PosResource::class;

    protected function getActions(): array
    {
        return [
            Action::make('assign')
                ->label('ASSIGN POS')
                ->url(fn () => PosResource::getUrl('assign')),
        ];
    }
}
