<?php

declare(strict_types=1);

namespace App\Queries\Company\GetAll;

use App\Shared\Traits\StaticConstructor;
use App\Shared\Traits\ToArray;
use Infrastructure\Services\QueryBus\Contracts\QueryInterface;

final class GetAllCompanyQuery implements QueryInterface
{
    use StaticConstructor, ToArray;

    /**
     * @param array{
     *     page?: int,
     *     limit?: int,
     * }|null $pagination
     */
    private function __construct(
        private readonly ?string $name = null,
        private readonly ?string $description = null,
        private readonly ?string $companyOwnerId = null,
        private readonly ?array $pagination = null,
    ) {}

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getCompanyOwnerId(): ?string
    {
        return $this->companyOwnerId;
    }

    /**
     * @return array{
     *     page?: int,
     *     limit?: int,
     * }|null
     */
    public function getPagination(): ?array
    {
        return $this->pagination;
    }
}
