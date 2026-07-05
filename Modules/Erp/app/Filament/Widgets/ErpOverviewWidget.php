<?php

namespace Modules\Erp\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\Erp\Models\InventoryItem;
use Modules\Erp\Models\Order;

class ErpOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $pendingOrders = Order::query()->where('status', 'pending')->count();
        $lowStock = InventoryItem::query()
            ->whereColumn('quantity_on_hand', '<=', 'reorder_level')
            ->count();

        return [
            Stat::make('Pending orders', (string) $pendingOrders)
                ->description('Awaiting fulfillment')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('warning'),
            Stat::make('Inventory SKUs', (string) InventoryItem::query()->count())
                ->description("{$lowStock} at or below reorder level")
                ->descriptionIcon('heroicon-m-archive-box')
                ->color($lowStock > 0 ? 'danger' : 'success'),
            Stat::make('Fulfilled', (string) Order::query()->where('status', 'fulfilled')->count())
                ->description('Completed ERP orders')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),
        ];
    }
}
