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

    protected function setAuth(): self
    {
        $user = User::factory()->create();

        $token = $user->createToken('test')->plainTextToken;

        return $this->withHeader('Authorization', "Bearer $token");
    }
}
