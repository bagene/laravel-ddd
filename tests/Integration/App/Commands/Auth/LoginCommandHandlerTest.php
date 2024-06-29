<?php

declare(strict_types=1);

namespace Tests\Integration\App\Commands\Auth;

use App\Commands\Auth\Login\LoginCommand;
use App\Commands\Auth\Login\LoginCommandHandler;
use App\Shared\Response\ErrorResponse;
use Domains\User\Models\User;
use Domains\User\Response\LoginResponse;
use Tests\FeatureIntegrationTestCase;

final class LoginCommandHandlerTest extends FeatureIntegrationTestCase
{
    private LoginCommandHandler $command;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var LoginCommandHandler $command */
        $command = $this->app->make(LoginCommandHandler::class);
        $this->command = $command;

        User::factory()->create([
            'email' => 'test@example.org',
            'password' => 'password',
        ]);
    }

    public function testInvokeReturnSuccess(): void
    {
        $result = $this->command->__invoke(LoginCommand::fromArray([
            'email' => 'test@example.org',
            'password' => 'password',
        ]));

        $this->assertInstanceOf(LoginResponse::class, $result);
        $this->assertArrayHasKey('token', $result->toArray());
    }

    public function testInvokeReturnInvalidEmail(): void
    {
        $result = $this->command->__invoke(LoginCommand::fromArray([
            'email' => 'test2@example.org',
            'password' => 'password',
        ]));

        $this->assertInstanceOf(ErrorResponse::class, $result);
        $this->assertEquals(401, $result->getCode());
        $this->assertEquals('Invalid credentials', $result->getMessage());
    }

    public function testInvokeReturnInvalidPassword(): void
    {
        $result = $this->command->__invoke(LoginCommand::fromArray([
            'email' => 'test@example.org',
            'password' => 'password2',
        ]));

        $this->assertInstanceOf(ErrorResponse::class, $result);
        $this->assertEquals(401, $result->getCode());
        $this->assertEquals('Invalid credentials', $result->getMessage());
    }
}
