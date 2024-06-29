<?php

declare(strict_types=1);

namespace Tests\Unit\Domains\User\DTO;

use Domains\User\DTO\UpdateUserPayload;
use Tests\UnitTestCase;

final class UpdateUserPayloadTest extends UnitTestCase
{
    public function testGetters(): void
    {
        $payload = UpdateUserPayload::fromArray([
            'name' => 'John Doe',
            'email' => 'test@example.org',
        ]);

        $this->assertSame('John Doe', $payload->getName());
        $this->assertSame('test@example.org', $payload->getEmail());
    }
}
