<?php

namespace Modules\Erp\Listeners;

use Modules\Erp\Services\OrderFulfillmentService;
use Modules\Payments\Events\InvoicePaid;

class FulfillPaidInvoice
{
    public function __construct(
        private readonly OrderFulfillmentService $fulfillment,
    ) {}

    public function handle(InvoicePaid $event): void
    {
        $this->fulfillment->fulfill($event->invoice);
    }
}
