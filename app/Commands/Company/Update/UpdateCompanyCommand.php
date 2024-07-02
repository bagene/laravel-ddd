<?php

declare(strict_types=1);

namespace App\Commands\Company\Update;

use App\Shared\Traits\StaticConstructor;
use App\Shared\Traits\ToArray;
use Infrastructure\Services\CommandBus\Contracts\CommandInterface;

final class UpdateCompanyCommand implements CommandInterface
{
    use StaticConstructor, ToArray;

    private function __construct(
        private readonly string $id,
        private readonly string $name,
        private readonly string $description,
        private readonly string $companyOwnerId,
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

    public function getCompanyOwnerId(): string
    {
        return $this->companyOwnerId;
    }
}
