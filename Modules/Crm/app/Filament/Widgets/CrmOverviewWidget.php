<?php

namespace Modules\Crm\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\Crm\Models\Contact;
use Modules\Crm\Models\Lead;
use Modules\Crm\Models\Pipeline;

class CrmOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $openLeads = Lead::query()->where('status', 'open')->count();
        $pipelineValue = (int) Lead::query()->where('status', 'open')->sum('value_cents');

        return [
            Stat::make('Open leads', (string) $openLeads)
                ->description('Active opportunities')
                ->descriptionIcon('heroicon-m-funnel')
                ->color('primary'),
            Stat::make('Pipeline value', '$'.number_format($pipelineValue / 100, 0))
                ->description('Open lead total')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success'),
            Stat::make('Contacts', (string) Contact::query()->count())
                ->description(Pipeline::query()->count().' pipelines configured')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),
        ];
    }
}
