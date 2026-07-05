<?php

namespace Modules\Erp\Policies;

use App\Policies\Concerns\AllowsAuthenticatedAdmin;
use Modules\Erp\Models\InventoryItem;

class InventoryItemPolicy
{
    use AllowsAuthenticatedAdmin;
}
