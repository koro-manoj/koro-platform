<?php

namespace Modules\Payments\Filament\Resources\PaymentWebhookResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Modules\Payments\Filament\Resources\PaymentWebhookResource;

class ListPaymentWebhooks extends ListRecords
{
    protected static string $resource = PaymentWebhookResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
