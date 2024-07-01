<?php

declare(strict_types=1);

namespace Domains\Company\Response;

use App\Shared\Traits\StaticConstructor;
use App\Shared\Traits\ToArray;
use Infrastructure\Services\CommandBus\Contracts\CommandResponseInterface;

final class CompanyResponse implements CommandResponseInterface
{
    use StaticConstructor, ToArray;

    /**
     * @param array{
     *     id: string,
     *     name: string,
     *     email: string,
     *     email_verified_at: string,
     *     created_at: string,
     *     updated_at: string,
     * } $companyOwner
     */
    private function __construct(
        private readonly string $id,
        private readonly string $name,
        private readonly string $description,
        private readonly array $companyOwner,
        private readonly string $createdAt,
        private readonly string $updatedAt,
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return array{
     *      id: string,
     *      name: string,
     *      email: string,
     *      email_verified_at: string,
     *      created_at: string,
     *      updated_at: string,
     *  }
     */
    public function getCompanyOwner(): array
    {
        return $this->companyOwner;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }
}
