<?php

namespace Modules\Erp\Policies;

use App\Policies\Concerns\AllowsAuthenticatedAdmin;
use Modules\Erp\Models\Order;

class OrderPolicy
{
    use AllowsAuthenticatedAdmin;
}
