<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class BankTransferPage extends Page
{
    protected static ?int $navigationSort = 5;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.bank-transfer-page';
}
