<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class DashboardUserStatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $data = Trend::model(User::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perDay()
            ->count();

        $todayCount = User::query()
            ->whereDate('created_at', Carbon::today())
            ->count();
        $yesterdayCount = User::query()
            ->whereDate('created_at', Carbon::yesterday())
            ->count();

        $percentageIncrease = ($todayCount === 0 || $yesterdayCount === 0)
            ? 0
            : (($todayCount - $yesterdayCount) / $todayCount) * 100;

        return [
            Card::make(
                'Total Registered Users',
                User::all()->reject(fn ($user) => $user->hasAnyRole(not_swift()))->count()
            )->description(__('Total Number Registered Users.'))
            ->descriptionColor('primary'),
            Card::make('New Users', $todayCount)
            ->description(__($this->statement($percentageIncrease)))
            ->descriptionIcon($this->icon($yesterdayCount, $todayCount))
            ->chart($data->map(fn (TrendValue $value) => $value->aggregate)->toArray())
            ->descriptionColor('danger'),
        ];
    }

    protected function icon($yesterday, $today): string
    {
        return match ($today) {
            ($yesterday > $today) => "heroicon-s-trending-down",
            ($yesterday < $today) => "heroicon-s-trending-up",
            default => ""
        };
    }

    protected function statement($percentageIncrease): string
    {
        if ($percentageIncrease === 0) {
            return "";
        }

        return match ($percentageIncrease) {
            ($percentageIncrease > 0) => "{$percentageIncrease}% increase",
            ($percentageIncrease < 0) => "{$percentageIncrease}% decrease",
            default => ""
        };
    }
}
