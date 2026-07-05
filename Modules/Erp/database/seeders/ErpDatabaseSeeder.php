<?php

namespace Modules\Erp\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Ecommerce\Models\Product;
use Modules\Erp\Models\InventoryItem;

class ErpDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Product::query()->each(function (Product $product): void {
            InventoryItem::query()->updateOrCreate(
                ['sku' => $product->sku],
                [
                    'name' => $product->name,
                    'quantity_on_hand' => $product->stock,
                    'reorder_level' => max(5, (int) floor($product->stock / 5)),
                    'location' => 'MAIN',
                ]
            );
        });
    }
}
