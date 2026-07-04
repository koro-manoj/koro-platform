<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Core\Models\Integration;
use Nwidart\Modules\Facades\Module;
use Tests\TestCase;

class ModulesTest extends TestCase
{
    use RefreshDatabase;

    /** @var list<string> */
    private array $expectedModules = [
        'Core',
        'Payments',
        'Ecommerce',
        'Crm',
        'Cms',
        'Erp',
        'Api',
    ];

    public function test_all_seven_modules_are_enabled(): void
    {
        foreach ($this->expectedModules as $name) {
            $this->assertTrue(
                Module::isEnabled($name),
                "Module {$name} should be enabled."
            );
        }

        $this->assertCount(7, Module::allEnabled());
    }

    public function test_public_routes_respond(): void
    {
        $this->seed();

        $this->get('/shop')->assertOk();
        $this->get('/shop/products/starter-kit')->assertOk();
        $this->get('/pages/about')->assertOk();
    }

    public function test_api_login_and_products_endpoint(): void
    {
        $this->seed();

        $login = $this->postJson('/api/v1/auth/login', [
            'email' => 'admin@koro.test',
            'password' => 'password',
            'device_name' => 'phpunit',
        ]);

        $login->assertOk()->assertJsonStructure(['token']);

        $token = $login->json('token');

        $this->withToken($token)
            ->getJson('/api/v1/products')
            ->assertOk()
            ->assertJsonStructure(['data']);
    }

    public function test_integration_credentials_are_encrypted_at_rest(): void
    {
        $integration = Integration::query()->create([
            'name' => 'Stripe Sandbox',
            'provider' => 'stripe',
            'credentials' => ['secret_key' => 'sk_test_demo'],
            'is_active' => true,
        ]);

        $raw = $integration->getRawOriginal('credentials');

        $this->assertIsString($raw);
        $this->assertStringNotContainsString('sk_test_demo', $raw);
        $this->assertSame('sk_test_demo', $integration->fresh()->credentials['secret_key']);
    }

    public function test_payments_webhook_route_exists(): void
    {
        $this->postJson('/api/webhooks/stripe', ['id' => 'evt_test', 'type' => 'payment_intent.succeeded'])
            ->assertOk()
            ->assertJsonStructure(['received', 'id']);
    }
}
