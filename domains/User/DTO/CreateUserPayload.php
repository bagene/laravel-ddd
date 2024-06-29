<?php

declare(strict_types=1);

namespace Domains\User\DTO;

use App\Shared\AbstractDTO;
use App\Shared\Traits\StaticConstructor;

final class CreateUserPayload extends AbstractDTO
{
    use StaticConstructor;

    private function __construct(
        private readonly string $name,
        private readonly string $email,
        private readonly string $password,
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
