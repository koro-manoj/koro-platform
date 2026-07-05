<?php

namespace Modules\Payments\Services;

use Illuminate\Support\Facades\Log;
use Modules\Payments\Events\InvoicePaid;
use Modules\Payments\Models\Invoice;
use Modules\Payments\Models\Payment;
use Modules\Payments\Models\PaymentWebhook;

class PaymentWebhookProcessor
{
    public function process(PaymentWebhook $webhook): void
    {
        if ($webhook->processed_at !== null) {
            return;
        }

        $payload = $webhook->payload;
        $type = $webhook->event_type;

        if ($type === 'checkout.session.completed') {
            $this->handleCheckoutCompleted($payload);
        }

        $webhook->update([
            'status' => 'processed',
            'processed_at' => now(),
        ]);
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    private function handleCheckoutCompleted(array $payload): void
    {
        $sessionId = $payload['data']['object']['id'] ?? $payload['id'] ?? null;

        if (! is_string($sessionId)) {
            Log::warning('payments.webhook.checkout_completed_missing_session_id', [
                'webhook_type' => 'checkout.session.completed',
            ]);

            return;
        }

        $payment = Payment::query()
            ->where('stripe_checkout_session_id', $sessionId)
            ->first();

        if ($payment === null) {
            Log::warning('payments.webhook.payment_not_found', [
                'session_id' => $sessionId,
            ]);

            return;
        }

        $payment->update([
            'status' => 'succeeded',
            'paid_at' => now(),
        ]);

        $invoice = $payment->invoice;

        if ($invoice !== null && $invoice->status !== 'paid') {
            $invoice->update([
                'status' => 'paid',
                'paid_at' => now(),
                'gateway_reference' => $sessionId,
            ]);

            InvoicePaid::dispatch($invoice->fresh());
        }
    }

    public function markInvoicePaidFromSession(Invoice $invoice, Payment $payment): void
    {
        if ($invoice->status === 'paid') {
            return;
        }

        $payment->update([
            'status' => 'succeeded',
            'paid_at' => now(),
        ]);

        $invoice->update([
            'status' => 'paid',
            'paid_at' => now(),
            'gateway_reference' => $payment->stripe_checkout_session_id,
        ]);

        InvoicePaid::dispatch($invoice->fresh());
    }
}
