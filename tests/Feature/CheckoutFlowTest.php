<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Ecommerce\Models\Product;
use Tests\TestCase;

class CheckoutFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_complete_sandbox_checkout(): void
    {
        $this->seed();

        $product = Product::query()->where('slug', 'starter-kit')->firstOrFail();

        $this->get(route('shop.index'));

        $this->post(route('shop.cart.add', $product))->assertRedirect();

        $response = $this->post(route('shop.checkout'), [
            'customer_name' => 'Jordan Lee',
            'customer_email' => 'buyer@example.com',
        ]);

        $response->assertRedirect();
        $location = (string) $response->headers->get('Location');

        $this->get($location)
            ->assertOk()
            ->assertSee('Payment received');

        $this->assertDatabaseHas('invoices', [
            'customer_email' => 'buyer@example.com',
            'status' => 'paid',
        ]);
    }
}
