<?php

declare(strict_types=1);

namespace App\Commands\Company\Create;

use Domains\Company\Contracts\CompanyRepositoryInterface;
use Domains\Company\DTO\CompanyPayload;
use Domains\Company\Models\Company;
use Domains\Company\Response\CompanyResponse;
use Infrastructure\Services\Session\Contracts\SessionInterface;

final class CreateCompanyCommandHandler
{
    public function __construct(
        private readonly CompanyRepositoryInterface $repository,
        private readonly SessionInterface $session,
    ) {}

    public function __invoke(CreateCompanyCommand $command): CompanyResponse
    {
        /** @var Company $result */
        $result = $this->repository->create(
            CompanyPayload::fromArray([
                'name' => $command->getName(),
                'description' => $command->getDescription(),
                'companyOwnerId' => $command->getCompanyOwnerId() ?? $this->session->get()?->id,
            ])
        );

        return CompanyResponse::fromModel($result->load('company_owner'));
    }
}
