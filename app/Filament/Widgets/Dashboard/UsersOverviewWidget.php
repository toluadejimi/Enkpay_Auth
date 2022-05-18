<?php

namespace App\Filament\Widgets\Dashboard;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class UsersOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected static ?string $pollingInterval = '10s';

    public static function canView(): bool
    {
        return true; //Auth::user()->isAdmin();
    }

    protected function getCards(): array
    {
        return [
            Card::make('Total Users', User::query()->count())
                ->description(__('Total numbers registered users'))
                //->descriptionIcon('icon-user-admin')
                ->color('success'),
            Card::make('Today Users', User::query()
                ->whereDate('created_at', Carbon::today())->count())
                ->description(__('Total number of registered users today.'))
                ->color('success'),
        ];
    }
}
