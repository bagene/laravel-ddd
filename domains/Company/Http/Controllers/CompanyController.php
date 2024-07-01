<?php

declare(strict_types=1);

namespace Domains\Company\Http\Controllers;

use App\Commands\Company\Create\CreateCompanyCommand;
use App\Http\Controllers\Controller;
use Domains\Company\Http\Requests\CreateCompanyRequest;
use Illuminate\Http\JsonResponse;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Group;

#[Authenticated]
#[Group(name: 'Company', description: 'Company management')]
final class CompanyController extends Controller
{
    public function create(CreateCompanyRequest $request): JsonResponse
    {
        return $this->dispatch($request, CreateCompanyCommand::class);
    }
}
