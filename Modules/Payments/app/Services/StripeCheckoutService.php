<?php

namespace Modules\Payments\Services;

use Modules\Core\Services\IntegrationService;
use Modules\Payments\Models\Invoice;
use Modules\Payments\Models\Payment;
use Stripe\Checkout\Session as StripeCheckoutSession;
use Stripe\StripeClient;

class StripeCheckoutService
{
    public function __construct(
        private readonly IntegrationService $integrations,
    ) {}

    public function startCheckout(Invoice $invoice, string $successUrl, string $cancelUrl): Payment
    {
        $credentials = $this->integrations->credentials('stripe') ?? [];
        $secretKey = $credentials['secret_key'] ?? null;

        $lineItems = collect($invoice->line_items ?? [])->map(fn (array $item): array => [
            'quantity' => $item['quantity'],
            'price_data' => [
                'currency' => strtolower($invoice->currency),
                'unit_amount' => $item['unit_price_cents'],
                'product_data' => [
                    'name' => $item['name'],
                ],
            ],
        ])->all();

        if (! is_string($secretKey) || $secretKey === '' || str_contains($secretKey, 'replace')) {
            return $this->startSandboxCheckout($invoice, $successUrl);
        }

        $stripe = new StripeClient($secretKey);

        $session = $stripe->checkout->sessions->create([
            'mode' => 'payment',
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
            'customer_email' => $invoice->customer_email,
            'line_items' => $lineItems,
            'metadata' => [
                'invoice_number' => $invoice->number,
                'invoice_id' => (string) $invoice->id,
            ],
        ]);

        return Payment::query()->create([
            'invoice_id' => $invoice->id,
            'provider' => 'stripe',
            'status' => 'processing',
            'stripe_checkout_session_id' => $session->id,
            'amount_cents' => $invoice->amount_cents,
            'currency' => $invoice->currency,
            'provider_payload' => $session->toArray(),
        ]);
    }

    public function checkoutUrl(Payment $payment): ?string
    {
        $url = $payment->provider_payload['url'] ?? null;

        return is_string($url) ? $url : null;
    }

    public function retrieveSession(string $sessionId): StripeCheckoutSession
    {
        $credentials = $this->integrations->credentials('stripe') ?? [];
        $secretKey = $credentials['secret_key'] ?? '';

        $stripe = new StripeClient($secretKey);

        return $stripe->checkout->sessions->retrieve($sessionId);
    }

    private function startSandboxCheckout(Invoice $invoice, string $successUrl): Payment
    {
        $sessionId = 'cs_test_'.bin2hex(random_bytes(12));

        return Payment::query()->create([
            'invoice_id' => $invoice->id,
            'provider' => 'stripe',
            'status' => 'processing',
            'stripe_checkout_session_id' => $sessionId,
            'amount_cents' => $invoice->amount_cents,
            'currency' => $invoice->currency,
            'provider_payload' => [
                'id' => $sessionId,
                'url' => $successUrl.'?session_id='.$sessionId.'&sandbox=1',
                'mode' => 'sandbox',
            ],
        ]);
    }
}
