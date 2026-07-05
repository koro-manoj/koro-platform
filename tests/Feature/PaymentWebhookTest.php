<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Modules\Payments\Models\Invoice;
use Modules\Payments\Models\Payment;
use Tests\TestCase;

class PaymentWebhookTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_session_completed_marks_invoice_paid(): void
    {
        $this->seed();

        $product = \Modules\Ecommerce\Models\Product::query()->where('slug', 'starter-kit')->firstOrFail();
        $sessionId = 'cs_test_'.Str::random(12);

        $invoice = Invoice::query()->create([
            'number' => 'INV-'.Str::upper(Str::random(8)),
            'customer_email' => 'webhook@example.com',
            'customer_name' => 'Webhook Buyer',
            'amount_cents' => 4900,
            'currency' => 'USD',
            'status' => 'pending',
            'gateway' => 'stripe',
            'line_items' => [
                [
                    'product_id' => $product->id,
                    'sku' => $product->sku,
                    'name' => $product->name,
                    'quantity' => 1,
                    'unit_price_cents' => 4900,
                ],
            ],
        ]);

        Payment::query()->create([
            'invoice_id' => $invoice->id,
            'provider' => 'stripe',
            'status' => 'processing',
            'stripe_checkout_session_id' => $sessionId,
            'amount_cents' => 4900,
            'currency' => 'USD',
            'provider_payload' => ['id' => $sessionId],
        ]);

        $this->postJson('/api/webhooks/stripe', [
            'id' => 'evt_test_webhook_1',
            'type' => 'checkout.session.completed',
            'data' => [
                'object' => [
                    'id' => $sessionId,
                    'payment_status' => 'paid',
                ],
            ],
        ], [
            'Stripe-Signature' => 't=0,v1=test',
        ])->assertOk()->assertJson(['received' => true]);

        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'status' => 'paid',
        ]);

        $this->assertDatabaseHas('payments', [
            'invoice_id' => $invoice->id,
            'status' => 'succeeded',
        ]);

        $this->assertDatabaseHas('payment_webhooks', [
            'event_id' => 'evt_test_webhook_1',
            'event_type' => 'checkout.session.completed',
            'status' => 'processed',
        ]);
    }
}
