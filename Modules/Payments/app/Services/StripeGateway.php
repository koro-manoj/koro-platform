<?php

namespace Modules\Payments\Services;

use Modules\Payments\Contracts\PaymentGateway;
use Modules\Payments\Models\Invoice;

class StripeGateway implements PaymentGateway
{
    public function name(): string
    {
        return 'stripe';
    }

    public function charge(Invoice $invoice, array $options = []): array
    {
        return [
            'status' => 'pending',
            'gateway' => $this->name(),
            'reference' => 'pi_sandbox_'.uniqid(),
            'amount_cents' => $invoice->amount_cents,
            'message' => 'Sandbox charge — configure Stripe credentials in Core integrations.',
        ];
    }

    public function verifyWebhook(array $payload, ?string $signature = null): bool
    {
        return app()->environment('local') || ! empty($signature);
    }
}
