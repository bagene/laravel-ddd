<?php

declare(strict_types=1);

namespace App\Queries\Company\GetAll;

use App\Shared\Response\PaginatedResponse;
use Domains\Company\Contracts\CompanyRepositoryInterface;

final class GetAllCompanyQueryHandler
{
    public function __construct(private readonly CompanyRepositoryInterface $companyRepository) {}

    public function __invoke(GetAllCompanyQuery $query): PaginatedResponse
    {
        $companies = $this->companyRepository->search(
            pagination: $query->getPagination() ?? [],
            filters: $this->getFilters($query),
            with: ['company_owner']
        );

        return PaginatedResponse::fromArray($companies->toArray());
    }

    /**
     * @return array{
     *     name?: string,
     *     description?: string,
     *     companyOwnerId?: string,
     * }
     */
    private function getFilters(GetAllCompanyQuery $query): array
    {
        $filters = [];

        if ($query->getName()) {
            $filters['name'] = $query->getName();
        }

        if ($query->getDescription()) {
            $filters['description'] = $query->getDescription();
        }

        if ($query->getCompanyOwnerId()) {
            $filters['company_owner_id'] = $query->getCompanyOwnerId();
        }

        return $filters;
    }
}
