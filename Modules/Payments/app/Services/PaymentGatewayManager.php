<?php

namespace Modules\Payments\Services;

use Modules\Payments\Contracts\PaymentGateway;
use Modules\Payments\Models\Invoice;
use Modules\Payments\Models\PaymentWebhook;
use RuntimeException;

class PaymentGatewayManager
{
    /** @var array<string, PaymentGateway> */
    protected array $gateways = [];

    public function register(PaymentGateway $gateway): void
    {
        $this->gateways[$gateway->name()] = $gateway;
    }

    public function gateway(string $name): PaymentGateway
    {
        if (! isset($this->gateways[$name])) {
            throw new RuntimeException("Payment gateway [{$name}] is not registered.");
        }

        return $this->gateways[$name];
    }

    public function charge(Invoice $invoice, string $gateway, array $options = []): array
    {
        return $this->gateway($gateway)->charge($invoice, $options);
    }

    public function recordWebhook(string $gateway, string $eventId, string $eventType, array $payload): PaymentWebhook
    {
        return PaymentWebhook::query()->firstOrCreate(
            ['event_id' => $eventId],
            [
                'gateway' => $gateway,
                'event_type' => $eventType,
                'payload' => $payload,
                'status' => 'received',
            ]
        );
    }
}
