<?php

declare(strict_types=1);

namespace Tests\Unit\Domains\User\DTO;

use Domains\User\DTO\CreateUserPayload;
use Tests\UnitTestCase;

final class CreateUserPayloadTest extends UnitTestCase
{
    public function testGetters(): void
    {
        $payload = CreateUserPayload::fromArray([
            'name' => 'John Doe',
            'email' => 'test@example.org',
            'password' => 'password',
        ]);

        $this->assertSame('John Doe', $payload->getName());
        $this->assertSame('test@example.org', $payload->getEmail());
        $this->assertSame('password', $payload->getPassword());
    }
}
