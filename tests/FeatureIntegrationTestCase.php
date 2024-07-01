<?php

declare(strict_types=1);

namespace Tests;

use Domains\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class FeatureIntegrationTestCase extends BaseTestCase
{
    use RefreshDatabase;

    public const POST_METHOD = 'POST';

    public const GET_METHOD = 'GET';

    private User $adminUser;

    protected function setAuth(?User $user = null): self
    {
        /** @var User $user */
        $user = $user ?: User::factory()->create();

        $this->adminUser = $user;

        $token = $user->createToken('test')->plainTextToken;

        return $this->withHeader('Authorization', "Bearer $token");
    }
}
