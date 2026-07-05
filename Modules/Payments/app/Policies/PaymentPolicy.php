<?php

namespace Modules\Payments\Policies;

use App\Models\User;
use App\Policies\Concerns\AllowsAuthenticatedAdmin;
use Modules\Payments\Models\Payment;

class PaymentPolicy
{
    use AllowsAuthenticatedAdmin;

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Payment $model): bool
    {
        return false;
    }

    public function delete(User $user, Payment $model): bool
    {
        return false;
    }
}
