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
        private string $uuid,
        private string $firstName,
        private string $lastName,
        private string $email,
        private string $address,
        private string $phoneNumber,
        private bool $isMarketing,
        private bool $isAdmin,
        private ?string $avatar,
        private string $createdAt,
        private string $updatedAt,
        private ?string $lastLoginAt,
    ) {
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function getIsMarketing(): bool
    {
        return $this->isMarketing;
    }

    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getLastLoginAt(): ?string
    {
        return $this->lastLoginAt;
    }
}
