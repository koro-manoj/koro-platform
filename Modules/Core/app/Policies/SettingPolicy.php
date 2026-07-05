<?php

namespace Modules\Core\Policies;

use App\Policies\Concerns\AllowsAuthenticatedAdmin;
use Modules\Core\Models\Setting;

class SettingPolicy
{
    use AllowsAuthenticatedAdmin;
}
