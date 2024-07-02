<?php

declare(strict_types=1);

namespace Tests\Integration\App\Commands\Company\Update;

use App\Commands\Company\Update\UpdateCompanyCommand;
use App\Commands\Company\Update\UpdateCompanyCommandHandler;
use App\Shared\Response\ErrorResponse;
use Domains\Company\Models\Company;
use Domains\Company\Response\CompanyResponse;
use Tests\FeatureIntegrationTestCase;

final class UpdateCompanyCommandHandlerTest extends FeatureIntegrationTestCase
{
    private UpdateCompanyCommandHandler $handler;

    private Company $company;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setAuth();

        /** @var UpdateCompanyCommandHandler $handler */
        $handler = $this->app->make(UpdateCompanyCommandHandler::class);
        $this->handler = $handler;

        /** @var Company $company */
        $company = Company::factory()->create([
            'name' => 'Company Name',
            'company_owner_id' => $this::$adminUser->id,
        ]);
        $this->company = $company;
    }

    public function testInvokeReturnSuccess(): void
    {
        $response = $this->handler->__invoke(
            UpdateCompanyCommand::fromArray([
                'id' => $this->company->id,
                'name' => 'New Company Name',
                'description' => 'New Company Description',
                'company_owner_id' => $this::$adminUser->id,
            ])
        );

        $this->assertInstanceOf(CompanyResponse::class, $response);
        $this->assertSame('New Company Name', $response->getName());
        $this->assertSame('New Company Description', $response->getDescription());

        $this->assertDatabaseMissing('companies', [
            'id' => $this->company->id,
            'name' => 'Company Name',
            'description' => 'Company Description',
        ]);

        $this->assertDatabaseHas('companies', [
            'id' => $this->company->id,
            'name' => 'New Company Name',
            'description' => 'New Company Description',
        ]);
    }

    public function testInvokeReturnErrorResponse(): void
    {
        $response = $this->handler->__invoke(
            UpdateCompanyCommand::fromArray([
                'id' => 'invalid-id',
                'name' => 'New Company Name',
                'description' => 'New Company Description',
                'company_owner_id' => $this::$adminUser->id,
            ])
        );

        $this->assertInstanceOf(ErrorResponse::class, $response);

        $this->assertMatchesPattern([
            'message' => 'Company not found',
            'code' => 404,
        ], $response->toArray());
    }
}
