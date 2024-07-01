<?php

declare(strict_types=1);

namespace App\Commands\Company\Create;

use App\Shared\Traits\StaticConstructor;
use Infrastructure\Services\CommandBus\Contracts\CommandInterface;

final class CreateCompanyCommand implements CommandInterface
{
    use StaticConstructor;

    private function __construct(
        private readonly string $name,
        private readonly string $description,
        private readonly ?string $companyOwnerId = null,
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCompanyOwnerId(): ?string
    {
        return $this->companyOwnerId;
    }
}
