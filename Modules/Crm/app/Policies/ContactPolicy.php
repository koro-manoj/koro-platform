<?php

namespace Modules\Crm\Policies;

use App\Policies\Concerns\AllowsAuthenticatedAdmin;
use Modules\Crm\Models\Contact;

class ContactPolicy
{
    use AllowsAuthenticatedAdmin;
}
