<?php

declare(strict_types=1);

namespace Domains\User\Response;

use App\Shared\Traits\StaticConstructor;
use App\Shared\Traits\ToArray;
use Infrastructure\Services\CommandBus\Contracts\CommandResponseInterface;

final class LoginResponse implements CommandResponseInterface
{
    use StaticConstructor, ToArray;

    private function __construct(
        private readonly string $token,
    ) {}

    public function getToken(): string
    {
        return $this->token;
    }
}
