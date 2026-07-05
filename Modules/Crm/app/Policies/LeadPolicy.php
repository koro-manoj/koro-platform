<?php

namespace Modules\Crm\Policies;

use App\Policies\Concerns\AllowsAuthenticatedAdmin;
use Modules\Crm\Models\Lead;

class LeadPolicy
{
    use AllowsAuthenticatedAdmin;
}
