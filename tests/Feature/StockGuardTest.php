<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Ecommerce\Models\Product;
use Tests\TestCase;

class StockGuardTest extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_add_out_of_stock_product_to_cart(): void
    {
        $this->seed();

        $product = Product::query()->where('slug', 'starter-kit')->firstOrFail();
        $product->update(['stock' => 0]);

        $this->get(route('shop.index'));

        $this->post(route('shop.cart.add', $product))
            ->assertRedirect()
            ->assertSessionHas('error');

        $this->assertDatabaseCount('cart_items', 0);
    }

    public function test_cannot_exceed_available_stock(): void
    {
        $this->seed();

        $product = Product::query()->where('slug', 'starter-kit')->firstOrFail();
        $product->update(['stock' => 1]);

        $this->get(route('shop.index'));

        $this->post(route('shop.cart.add', $product))->assertRedirect();
        $this->post(route('shop.cart.add', $product))
            ->assertRedirect()
            ->assertSessionHas('error');

        $this->assertDatabaseHas('cart_items', [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
    }

    public function test_out_of_stock_product_page_hides_add_button(): void
    {
        $this->seed();

        $product = Product::query()->where('slug', 'starter-kit')->firstOrFail();
        $product->update(['stock' => 0]);

        $this->get(route('shop.show', $product))
            ->assertOk()
            ->assertSee('Out of stock')
            ->assertDontSee('Add to cart');
    }
}
