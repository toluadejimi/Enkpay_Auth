<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Filament\Widgets\Dashboard\RecentTransactions;
use App\Filament\Widgets\Dashboard\UsersOverviewWidget;

class Dashboard extends Page
{
    protected static ?int $navigationSort = 0;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.dashboard';

    protected function getHeaderWidgets(): array
    {
        return [
            UsersOverviewWidget::class,
            RecentTransactions::class,
        ];

    }


    // Total Sum of users, Total Sum of income, Total sum of out
    // Total sum of Registered Agent, Recent transactions
}
