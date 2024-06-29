<?php

declare(strict_types=1);

namespace Tests\Unit\App\Commands\Auth\Login;

use App\Commands\Auth\Login\LoginCommand;
use Tests\UnitTestCase;

final class LoginCommandTest extends UnitTestCase
{
    public function testGetters(): void
    {
        $command = LoginCommand::fromArray([
            'email' => 'test@example.org',
            'password' => 'password',
        ]);

        $this->assertIsString($command->getEmail());
        $this->assertEquals('test@example.org', $command->getEmail());
        $this->assertIsString($command->getPassword());
        $this->assertEquals('password', $command->getPassword());
    }
}
