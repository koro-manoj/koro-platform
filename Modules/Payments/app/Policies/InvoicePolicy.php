<?php

namespace Modules\Payments\Policies;

use App\Policies\Concerns\AllowsAuthenticatedAdmin;
use Modules\Payments\Models\Invoice;

class InvoicePolicy
{
    use AllowsAuthenticatedAdmin;
}
