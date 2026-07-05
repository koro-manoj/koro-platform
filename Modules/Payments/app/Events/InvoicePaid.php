<?php

namespace Modules\Payments\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Payments\Models\Invoice;

class InvoicePaid
{
    use Dispatchable, SerializesModels;

    public function __construct(public Invoice $invoice) {}
}
