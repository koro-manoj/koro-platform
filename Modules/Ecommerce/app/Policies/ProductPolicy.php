<?php

namespace Modules\Ecommerce\Policies;

use App\Policies\Concerns\AllowsAuthenticatedAdmin;
use Modules\Ecommerce\Models\Product;

class ProductPolicy
{
    use AllowsAuthenticatedAdmin;
}
