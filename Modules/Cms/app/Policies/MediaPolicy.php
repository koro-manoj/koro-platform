<?php

namespace Modules\Cms\Policies;

use App\Policies\Concerns\AllowsAuthenticatedAdmin;
use Modules\Cms\Models\Media;

class MediaPolicy
{
    use AllowsAuthenticatedAdmin;
}
