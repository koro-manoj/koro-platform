<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Modules\Crm\Models\Pipeline;
use Tests\TestCase;

class PolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_admin_can_manage_module_resources(): void
    {
        $this->seed();

        $user = User::query()->where('email', 'admin@koro.test')->firstOrFail();

        $this->assertTrue(Gate::forUser($user)->allows('viewAny', Pipeline::class));
        $this->assertTrue(Gate::forUser($user)->allows('create', Pipeline::class));
    }
}
