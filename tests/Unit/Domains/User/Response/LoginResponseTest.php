<?php

declare(strict_types=1);

namespace Tests\Unit\Domains\User\Response;

use Domains\User\Response\LoginResponse;
use Tests\UnitTestCase;

final class LoginResponseTest extends UnitTestCase
{
    public function testGetters(): void
    {
        $response = LoginResponse::fromArray([
            'token' => 'token',
        ]);

        $this->assertIsString($response->getToken());
        $this->assertEquals('token', $response->getToken());
    }
}
