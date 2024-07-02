<?php

declare(strict_types=1);

namespace Tests\Integration\App\Queries\Company\Get;

use App\Queries\Company\Get\GetCompanyQuery;
use App\Queries\Company\Get\GetCompanyQueryHandler;
use App\Shared\Response\ErrorResponse;
use Domains\Company\Models\Company;
use Domains\Company\Response\CompanyResponse;
use Tests\FeatureIntegrationTestCase;

final class GetCompanyQueryHandlerTest extends FeatureIntegrationTestCase
{
    private GetCompanyQueryHandler $handler;

    private Company $company;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setAuth();

        /** @var GetCompanyQueryHandler $handler */
        $handler = $this->app->make(GetCompanyQueryHandler::class);
        $this->handler = $handler;

        /** @var Company $company */
        $company = Company::factory()->create([
            'company_owner_id' => $this::$adminUser->id,
        ]);
        $this->company = $company;
    }

    public function testInvokeReturnSuccess(): void
    {
        $response = $this->handler->__invoke(GetCompanyQuery::fromArray([
            'id' => $this->company->id,
        ]));

        $this->assertInstanceOf(CompanyResponse::class, $response);
        $this->assertMatchesPattern([
            'id' => $this->company->id,
            'name' => $this->company->name,
            'description' => $this->company->description,
            'company_owner' => $this->company->company_owner->toArray(),
            'created_at' => $this->company->created_at->toISOString(),
            'updated_at' => $this->company->updated_at->toISOString(),
        ], $response->toArray());
    }

    public function testInvokeReturnErrorResponse(): void
    {
        $response = $this->handler->__invoke(GetCompanyQuery::fromArray([
            'id' => 'invalid-id',
        ]));

        $this->assertInstanceOf(ErrorResponse::class, $response);

        $this->assertMatchesPattern([
            'message' => 'Company not found',
            'code' => 404,
        ], $response->toArray());
    }
}
