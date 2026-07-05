<?php

namespace Modules\Core\Policies;

use App\Policies\Concerns\AllowsAuthenticatedAdmin;
use Modules\Core\Models\Integration;

class IntegrationPolicy
{
    use AllowsAuthenticatedAdmin;
}
