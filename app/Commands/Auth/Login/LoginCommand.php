<?php

declare(strict_types=1);

namespace App\Commands\Auth\Login;

use App\Shared\Traits\StaticConstructor;
use Infrastructure\Services\CommandBus\Contracts\CommandInterface;

final class LoginCommand implements CommandInterface
{
    use StaticConstructor;

    private function __construct(
        private readonly string $email,
        private readonly string $password,
    ) {}

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
