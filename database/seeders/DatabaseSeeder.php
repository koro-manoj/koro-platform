<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Modules\Cms\Models\Page;
use Modules\Crm\Models\Contact;
use Modules\Crm\Models\Lead;
use Modules\Crm\Models\Pipeline;
use Modules\Crm\Models\PipelineStage;
use Modules\Ecommerce\Models\Product;
use Modules\Erp\Models\InventoryItem;
use Modules\Erp\Models\Order;
use Modules\Payments\Models\Invoice;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@koro.test'],
            [
                'name' => 'Platform Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        Product::query()->updateOrCreate(
            ['sku' => 'DEMO-001'],
            [
                'name' => 'Starter Kit',
                'slug' => 'starter-kit',
                'description' => 'Demo product for the Koro storefront.',
                'price_cents' => 4900,
                'currency' => 'USD',
                'stock' => 25,
                'is_active' => true,
            ]
        );

        Product::query()->updateOrCreate(
            ['sku' => 'DEMO-002'],
            [
                'name' => 'Pro Bundle',
                'slug' => 'pro-bundle',
                'description' => 'Second demo product with higher price point.',
                'price_cents' => 12900,
                'currency' => 'USD',
                'stock' => 10,
                'is_active' => true,
            ]
        );

        Page::query()->updateOrCreate(
            ['slug' => 'about'],
            [
                'title' => 'About Koro',
                'content' => '<p>Koro Platform is a modular Laravel showcase for client proposals and portfolio demos.</p>',
                'status' => 'published',
                'published_at' => now(),
            ]
        );

        $pipeline = Pipeline::query()->firstOrCreate(['name' => 'Default Sales'], ['is_default' => true]);
        $stage = PipelineStage::query()->firstOrCreate(
            ['pipeline_id' => $pipeline->id, 'name' => 'Qualified'],
            ['sort_order' => 1]
        );

        $contact = Contact::query()->firstOrCreate(
            ['email' => 'lead@example.com'],
            ['first_name' => 'Alex', 'last_name' => 'Rivera', 'company' => 'Acme Co']
        );

        Lead::query()->firstOrCreate(
            ['title' => 'Acme onboarding'],
            [
                'contact_id' => $contact->id,
                'pipeline_id' => $pipeline->id,
                'pipeline_stage_id' => $stage->id,
                'value_cents' => 250000,
                'status' => 'open',
            ]
        );

        Invoice::query()->firstOrCreate(
            ['number' => 'INV-1001'],
            [
                'customer_email' => 'billing@example.com',
                'customer_name' => 'Acme Co',
                'amount_cents' => 9900,
                'currency' => 'USD',
                'status' => 'paid',
                'gateway' => 'stripe',
                'paid_at' => now(),
            ]
        );

        InventoryItem::query()->firstOrCreate(
            ['sku' => 'WH-001'],
            ['name' => 'Warehouse stock', 'quantity_on_hand' => 120, 'reorder_level' => 20, 'location' => 'A-12']
        );

        Order::query()->firstOrCreate(
            ['order_number' => 'ERP-1001'],
            ['status' => 'pending', 'total_cents' => 4900, 'line_items' => [['sku' => 'DEMO-001', 'qty' => 1]]]
        );
    }
}
