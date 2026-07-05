<?php

namespace Modules\Ecommerce\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Modules\Ecommerce\Models\Cart;
use Modules\Ecommerce\Models\CartItem;
use Modules\Ecommerce\Models\Product;
use Modules\Payments\Models\Invoice;
use Modules\Payments\Models\Payment;
use Modules\Payments\Services\PaymentWebhookProcessor;
use Modules\Payments\Services\StripeCheckoutService;

class CartController extends Controller
{
    public function show(Request $request): View
    {
        $cart = $this->resolveCart($request);
        $cart->load('items.product');

        return view('ecommerce::shop.cart', compact('cart'));
    }

    public function checkoutForm(Request $request): View|RedirectResponse
    {
        $cart = $this->resolveCart($request);
        $cart->load('items.product');

        if ($cart->items->isEmpty()) {
            return redirect()->route('shop.cart')->with('error', 'Your cart is empty.');
        }

        $user = $request->user();

        return view('ecommerce::shop.checkout', [
            'cart' => $cart,
            'customerName' => old('customer_name', $user?->name),
            'customerEmail' => old('customer_email', $user?->email),
        ]);
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

    public function checkout(Request $request, StripeCheckoutService $checkout): RedirectResponse
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:120'],
            'customer_email' => ['required', 'email', 'max:255'],
        ]);

        $cart = $this->resolveCart($request);
        $cart->load('items.product');

        if ($cart->items->isEmpty()) {
            return redirect()->route('shop.cart')->with('error', 'Your cart is empty.');
        }

        $amountCents = $cart->subtotalCents();

        $lineItems = $cart->items->map(fn (CartItem $item): array => [
            'product_id' => $item->product_id,
            'name' => $item->product->name,
            'quantity' => $item->quantity,
            'unit_price_cents' => $item->unit_price_cents,
        ])->values()->all();

        $invoice = Invoice::query()->create([
            'number' => 'INV-'.Str::upper(Str::random(8)),
            'user_id' => $request->user()?->id,
            'cart_id' => $cart->id,
            'customer_email' => $validated['customer_email'],
            'customer_name' => $validated['customer_name'],
            'amount_cents' => $amountCents,
            'currency' => 'USD',
            'status' => 'pending',
            'gateway' => 'stripe',
            'line_items' => $lineItems,
        ]);

        $payment = $checkout->startCheckout(
            $invoice,
            route('shop.checkout.success', ['invoice' => $invoice->number]),
            route('shop.checkout.cancel', ['invoice' => $invoice->number]),
        );

        $url = $checkout->checkoutUrl($payment);

        if ($url === null) {
            return back()->with('error', 'Unable to start checkout. Configure Stripe in Core → Integrations.');
        }

        return redirect($url);
    }

    public function success(
        Request $request,
        Invoice $invoice,
        StripeCheckoutService $checkout,
        PaymentWebhookProcessor $processor,
    ): View {
        $sessionId = $request->string('session_id')->toString();
        $isSandbox = $request->boolean('sandbox');

        $payment = Payment::query()
            ->where('invoice_id', $invoice->id)
            ->latest()
            ->first();

        if ($payment && $invoice->status !== 'paid') {
            if ($isSandbox) {
                $processor->markInvoicePaidFromSession($invoice, $payment);
            } elseif ($sessionId !== '') {
                try {
                    $session = $checkout->retrieveSession($sessionId);
                    if ($session->payment_status === 'paid') {
                        $processor->markInvoicePaidFromSession($invoice, $payment);
                    }
                } catch (\Throwable) {
                    // Webhook will finalize if session retrieval fails.
                }
            }
        }

        $this->finalizeCart($invoice);

        return view('ecommerce::shop.checkout-success', [
            'invoice' => $invoice->fresh(),
            'sandbox' => $isSandbox,
        ]);
    }

    public function cancel(Invoice $invoice): View
    {
        return view('ecommerce::shop.checkout-cancel', compact('invoice'));
    }

    protected function resolveCart(Request $request): Cart
    {
        $session = $request->session();

        if ($session->has('cart_id')) {
            $cart = Cart::query()
                ->where('id', $session->get('cart_id'))
                ->where('status', 'open')
                ->first();

            if ($cart !== null) {
                return $cart;
            }
        }

        $cart = Cart::query()->firstOrCreate(
            ['session_id' => $session->getId(), 'status' => 'open'],
            ['user_id' => $request->user()?->id]
        );

        $session->put('cart_id', $cart->id);

        return $cart;
    }

    protected function finalizeCart(Invoice $invoice): void
    {
        if ($invoice->status !== 'paid' || $invoice->cart_id === null) {
            return;
        }

        $cart = Cart::query()->find($invoice->cart_id);

        if ($cart === null) {
            return;
        }

        $cart->items()->delete();
        $cart->update(['status' => 'checked_out']);
    }
}
