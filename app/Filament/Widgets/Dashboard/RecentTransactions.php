<?php

namespace App\Filament\Widgets\Dashboard;

use Closure;
use Filament\Tables;
use Bavix\Wallet\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentTransactions extends BaseWidget
{
    protected function getTableQuery(): Builder
    {
        return Transaction::query()->latest()->limit(10);
    }

    protected function getTableColumns(): array
    {
        return [
            // ...
        ];
    }
}
