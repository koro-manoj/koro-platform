<?php

namespace Modules\Crm\Policies;

use App\Policies\Concerns\AllowsAuthenticatedAdmin;
use Modules\Crm\Models\Pipeline;

class PipelinePolicy
{
    use AllowsAuthenticatedAdmin;
}
