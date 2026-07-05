<?php

namespace Modules\Core\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\Core\Models\Integration;
use Modules\Core\Models\Setting;

class CoreOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $integrations = Integration::query()->count();
        $activeIntegrations = Integration::query()->where('is_active', true)->count();
        $settings = Setting::query()->count();

        return [
            Stat::make('Integrations', (string) $integrations)
                ->description("{$activeIntegrations} active")
                ->descriptionIcon('heroicon-m-key')
                ->color('primary'),
            Stat::make('Settings', (string) $settings)
                ->description('Platform configuration keys')
                ->descriptionIcon('heroicon-m-cog-6-tooth')
                ->color('gray'),
            Stat::make('Secrets', 'DB encrypted')
                ->description('Stripe keys stored in Core, not .env')
                ->descriptionIcon('heroicon-m-shield-check')
                ->color('success'),
        ];
    }
}
