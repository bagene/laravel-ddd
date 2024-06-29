<?php

declare(strict_types=1);

namespace App\Shared\Response;

use App\Shared\Traits\StaticConstructor;
use App\Shared\Traits\ToArray;
use Infrastructure\Services\CommandBus\Contracts\CommandResponseInterface;
use Infrastructure\Services\QueryBus\Contracts\QueryResponseInterface;

final readonly class UserResponse implements CommandResponseInterface, QueryResponseInterface
{
    use StaticConstructor, ToArray;

    private function __construct(
        private string $id,
        private string $name,
        private string $email,
        private string $emailVerifiedAt,
        private string $createdAt,
        private string $updatedAt,
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function getEmailVerifiedAt(): string
    {
        return $this->emailVerifiedAt;
    }
}
