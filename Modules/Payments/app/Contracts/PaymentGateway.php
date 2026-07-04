<?php

namespace Modules\Payments\Contracts;

use Modules\Payments\Models\Invoice;

interface PaymentGateway
{
    public function name(): string;

    public function charge(Invoice $invoice, array $options = []): array;

    public function verifyWebhook(array $payload, ?string $signature = null): bool;
}
