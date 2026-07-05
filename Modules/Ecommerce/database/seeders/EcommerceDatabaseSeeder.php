<?php

namespace Modules\Ecommerce\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Ecommerce\Models\Product;

class EcommerceDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $catalog = [
            [
                'sku' => 'KORO-001',
                'slug' => 'starter-kit',
                'name' => 'Starter Kit',
                'description' => 'Essentials bundle for teams shipping their first modular product.',
                'price_cents' => 4900,
                'compare_at_price_cents' => 5900,
                'category' => 'kits',
                'badge' => 'Popular',
                'image_url' => 'https://images.pexels.com/photos/1183266/pexels-photo-1183266.jpeg?auto=compress&cs=tinysrgb&w=800',
                'stock' => 25,
            ],
            [
                'sku' => 'KORO-002',
                'slug' => 'pro-bundle',
                'name' => 'Pro Bundle',
                'description' => 'Expanded toolkit with premium support hooks and analytics-ready events.',
                'price_cents' => 12900,
                'category' => 'kits',
                'badge' => 'Best value',
                'image_url' => 'https://images.pexels.com/photos/3730760/pexels-photo-3730760.jpeg?auto=compress&cs=tinysrgb&w=800',
                'stock' => 10,
            ],
            [
                'sku' => 'KORO-003',
                'slug' => 'desk-lamp',
                'name' => 'Focus Desk Lamp',
                'description' => 'Warm adjustable lamp for late-night deploys and deep work sessions.',
                'price_cents' => 7800,
                'category' => 'desk',
                'image_url' => 'https://images.pexels.com/photos/1117132/pexels-photo-1117132.jpeg?auto=compress&cs=tinysrgb&w=800',
                'stock' => 18,
            ],
            [
                'sku' => 'KORO-004',
                'slug' => 'travel-pack',
                'name' => 'Travel Pack',
                'description' => 'Compact carry with padded laptop sleeve and cable pass-through.',
                'price_cents' => 9800,
                'category' => 'travel',
                'badge' => 'New',
                'image_url' => 'https://images.pexels.com/photos/2905238/pexels-photo-2905238.jpeg?auto=compress&cs=tinysrgb&w=800',
                'stock' => 14,
            ],
        ];

        foreach ($catalog as $item) {
            Product::query()->updateOrCreate(
                ['sku' => $item['sku']],
                array_merge($item, [
                    'currency' => 'USD',
                    'is_active' => true,
                ])
            );
        }
    }
}
