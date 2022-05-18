<?php

namespace App\Filament\Pages;

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
            // ...
        ];
    }
}
