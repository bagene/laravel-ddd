<?php

declare(strict_types=1);

namespace Domains\Company\DTO;

use App\Shared\AbstractDTO;
use App\Shared\Traits\StaticConstructor;

final class CompanyPayload extends AbstractDTO
{
    use StaticConstructor;

    private function __construct(
        private readonly string $name,
        private readonly string $description,
        private readonly string $companyOwnerId,
    ) {}

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
