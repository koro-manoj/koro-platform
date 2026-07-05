<?php

namespace Modules\Crm\Policies;

use App\Policies\Concerns\AllowsAuthenticatedAdmin;
use Modules\Crm\Models\PipelineStage;

class PipelineStagePolicy
{
    use AllowsAuthenticatedAdmin;
}
