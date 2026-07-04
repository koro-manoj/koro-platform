<?php

namespace Modules\Ecommerce\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Modules\Ecommerce\Models\Cart;
use Modules\Ecommerce\Models\CartItem;
use Modules\Ecommerce\Models\Product;
use Modules\Payments\Models\Invoice;
use Modules\Payments\Services\PaymentGatewayManager;

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

    public function remove(Request $request, CartItem $item): RedirectResponse
    {
        $cart = $this->resolveCart($request);

        if ($item->cart_id === $cart->id) {
            $item->delete();
        }

        return back()->with('success', 'Item removed.');
    }

    public function checkout(Request $request, PaymentGatewayManager $payments): RedirectResponse
    {
        $cart = $this->resolveCart($request);
        $cart->load('items.product');

        if ($cart->items->isEmpty()) {
            return back()->with('error', 'Your cart is empty.');
        }

        $amountCents = $cart->items->sum(
            fn (CartItem $item): int => $item->quantity * $item->unit_price_cents
        );

        $lineItems = $cart->items->map(fn (CartItem $item): array => [
            'product_id' => $item->product_id,
            'name' => $item->product->name,
            'quantity' => $item->quantity,
            'unit_price_cents' => $item->unit_price_cents,
        ])->values()->all();

        $user = $request->user();

        $invoice = Invoice::query()->create([
            'number' => 'INV-'.Str::upper(Str::random(8)),
            'user_id' => $user?->id,
            'customer_email' => $user?->email ?? 'guest@koro.test',
            'customer_name' => $user?->name ?? 'Guest',
            'amount_cents' => $amountCents,
            'currency' => 'USD',
            'status' => 'pending',
            'gateway' => 'stripe',
            'line_items' => $lineItems,
        ]);

        $result = $payments->charge($invoice, 'stripe');

        $invoice->update([
            'status' => 'paid',
            'gateway_reference' => $result['reference'] ?? null,
            'paid_at' => now(),
        ]);

        $cart->update(['status' => 'checked_out']);

        return redirect()
            ->route('shop.index')
            ->with('success', 'Payment complete. Invoice '.$invoice->number);
    }

    protected function resolveCart(Request $request): Cart
    {
        return Cart::query()->firstOrCreate(
            ['session_id' => $request->session()->getId(), 'status' => 'open'],
            ['user_id' => $request->user()?->id]
        );
    }
}
