<?php

namespace Modules\Cms\Policies;

use App\Policies\Concerns\AllowsAuthenticatedAdmin;
use Modules\Cms\Models\Page;

class PagePolicy
{
    use AllowsAuthenticatedAdmin;
}
