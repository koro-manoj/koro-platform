<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Core\Services\IntegrationService;

class CoreDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        app(IntegrationService::class)->store(
            'stripe',
            'Stripe Sandbox',
            [
                'publishable_key' => 'pk_test_replace_me',
                'secret_key' => 'sk_test_replace_me',
                'webhook_secret' => 'whsec_replace_me',
            ],
            ['mode' => 'sandbox'],
        );
    }
}
