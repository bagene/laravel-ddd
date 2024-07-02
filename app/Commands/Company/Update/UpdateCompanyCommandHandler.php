<?php

declare(strict_types=1);

namespace App\Commands\Company\Update;

use App\Shared\Response\ErrorResponse;
use Domains\Company\Contracts\CompanyRepositoryInterface;
use Domains\Company\DTO\CompanyPayload;
use Domains\Company\Response\CompanyResponse;

final class UpdateCompanyCommandHandler
{
    public function __construct(
        private readonly CompanyRepositoryInterface $companyRepository
    ) {}

    public function __invoke(UpdateCompanyCommand $command): CompanyResponse|ErrorResponse
    {
        $company = $this->companyRepository->find($command->getId());

        if (! $company) {
            return ErrorResponse::create('Company not found', 404);
        }

        $company = $this->companyRepository->update(
            model: $company,
            dto: CompanyPayload::fromArray($command->toArray()),
        );

        return CompanyResponse::fromModel(
            $company->load('company_owner')
        );
    }
}
