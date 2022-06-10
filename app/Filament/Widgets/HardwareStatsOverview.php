<?php

namespace App\Filament\Widgets;

use App\Models\Pos;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class HardwareStatsOverview extends BaseWidget
{
    // Total Device (Big pos and Mpos), Total Big Pos, Total Mpos
    // Total Damage, Add Device
    protected function getCards(): array
    {
        return [
            Card::make('BIG POS', $this->getPOSDeviceCount()->BIGPOS)
                ->description(__('Total device type of BIGPOS'))
                ->descriptionColor('primary')
                ->descriptionIcon('heroicon-o-device-mobile'),
            Card::make('MPOS', $this->getPOSDeviceCount()->MPOS)
                ->description(__('Total device type of MPOS'))
                ->descriptionColor('success')
                ->descriptionIcon('heroicon-o-device-mobile'),
            Card::make('Repair', '0')
                ->description(__('Total device under repairs'))
                ->descriptionColor('danger')
                ->descriptionIcon('heroicon-o-cog'),
        ];
    }

    protected function getPOSDeviceCount()
    {
        return Pos::toBase()
            ->selectRaw("count(case when device_type = 'BigPOS' then 1 end) as BIGPOS")
            ->selectRaw("count(case when device_type = 'MPOS' then 1 end) as MPOS")
            ->first();
    }

    protected function getPOSRepairsCount(): void
    {
        // No provision for this...
    }
}
