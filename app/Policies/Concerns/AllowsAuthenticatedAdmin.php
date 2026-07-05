<?php

namespace App\Policies\Concerns;

use App\Models\User;

trait AllowsAuthenticatedAdmin
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, mixed $model): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, mixed $model): bool
    {
        return true;
    }

    public function delete(User $user, mixed $model): bool
    {
        return true;
    }

    public function restore(User $user, mixed $model): bool
    {
        return true;
    }

    public function forceDelete(User $user, mixed $model): bool
    {
        return true;
    }
}
