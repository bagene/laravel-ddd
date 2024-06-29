<?php

declare(strict_types=1);

namespace Domains\User\DTO;

use App\Shared\AbstractDTO;
use App\Shared\Traits\StaticConstructor;

final class UpdateUserPayload extends AbstractDTO
{
    use StaticConstructor;

    private function __construct(
        private readonly string $name,
        private readonly string $email,
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
