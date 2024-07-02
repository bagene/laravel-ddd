<?php

declare(strict_types=1);

namespace Domains\Company\Http\Controllers;

use App\Commands\Company\Create\CreateCompanyCommand;
use App\Commands\Company\Update\UpdateCompanyCommand;
use App\Http\Controllers\Controller;
use App\Queries\Company\Get\GetCompanyQuery;
use App\Queries\Company\GetAll\GetAllCompanyQuery;
use Domains\Company\Http\Requests\CompanyRequest;
use Illuminate\Http\JsonResponse;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\ResponseFromFile;

#[Authenticated]
#[Group(name: 'Company', description: 'Company management')]
final class CompanyController extends Controller
{
    #[ResponseFromFile(
        file: 'infrastructure/Schema/Company/company.json',
        status: 200,
    )]
    public function create(CompanyRequest $request): JsonResponse
    {
        return $this->dispatch($request, CreateCompanyCommand::class);
    }

    #[ResponseFromFile(
        file: 'infrastructure/Schema/Company/company.json',
        status: 200,
    )]
    public function search(): JsonResponse
    {
        return $this->ask(
            queryClass: GetAllCompanyQuery::class,
            wrapInData: false,
            fromQuery: true
        );
    }

    #[ResponseFromFile(
        file: 'infrastructure/Schema/Company/company.json',
        status: 200,
    )]
    public function get(): JsonResponse
    {
        return $this->ask(
            queryClass: GetCompanyQuery::class,
            fromQuery: true
        );
    }

    #[ResponseFromFile(
        file: 'infrastructure/Schema/Company/company.json',
        status: 200,
    )]
    public function update(CompanyRequest $request): JsonResponse
    {
        return $this->dispatch($request, UpdateCompanyCommand::class);
    }
}
