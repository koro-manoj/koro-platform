<?php

namespace Modules\Ecommerce\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Ecommerce\Models\Cart;
use Modules\Ecommerce\Models\CartItem;
use Modules\Ecommerce\Models\Product;

class CartController extends Controller
{
    public function show(Request $request)
    {
        $cart = $this->resolveCart($request);
        $cart->load('items.product');

        return view('ecommerce::shop.cart', compact('cart'));
    }

    public function add(Request $request, Product $product): RedirectResponse
    {
        $cart = $this->resolveCart($request);
        $item = CartItem::query()->firstOrNew([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
        ]);

        $item->quantity = ($item->exists ? $item->quantity : 0) + 1;
        $item->unit_price_cents = $product->price_cents;
        $item->save();

        return back()->with('success', 'Added to cart.');
    }

    public function checkout(Request $request): RedirectResponse
    {
        $cart = $this->resolveCart($request);
        $cart->update(['status' => 'checked_out']);

        return redirect()->route('shop.index')->with('success', 'Checkout complete (demo).');
    }

    protected function resolveCart(Request $request): Cart
    {
        return Cart::query()->firstOrCreate(
            ['session_id' => $request->session()->getId(), 'status' => 'open'],
            ['user_id' => $request->user()?->id]
        );
    }
}
