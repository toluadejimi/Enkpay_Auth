<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class HardwarePage extends Page
{
    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Device';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.hardware-page';

    // Total Device (Big pos and Mpos), Total Big Pos, Total Mpos
    // Total Damage, Add Device
}
