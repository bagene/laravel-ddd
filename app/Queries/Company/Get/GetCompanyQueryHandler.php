<?php

declare(strict_types=1);

namespace App\Queries\Company\Get;

use App\Shared\Response\ErrorResponse;
use Domains\Company\Contracts\CompanyRepositoryInterface;
use Domains\Company\Response\CompanyResponse;

final class GetCompanyQueryHandler
{
    public function __construct(
        private readonly CompanyRepositoryInterface $companyRepository
    ) {}

    public function __invoke(GetCompanyQuery $query): CompanyResponse|ErrorResponse
    {
        $company = $this->companyRepository->find(
            id: $query->getId(),
            with: ['company_owner']
        );

        if (! $company) {
            return ErrorResponse::create('Company not found', 404);
        }

        return CompanyResponse::fromModel($company);
    }
}
