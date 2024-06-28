<?php

declare(strict_types=1);

namespace App\Shared\Response;

use App\Shared\Traits\StaticConstructor;
use App\Shared\Traits\ToArray;
use Infrastructure\Services\CommandBus\Contracts\CommandResponseInterface;

final class AuthResponse implements CommandResponseInterface
{
    use StaticConstructor, ToArray;

    private function __construct(
        private readonly string $token,
        private readonly int $expiresIn,
    ) {}

    public function getToken(): string
    {
        return $this->token;
    }

    public function getExpiresIn(): int
    {
        return $this->expiresIn;
    }
}
