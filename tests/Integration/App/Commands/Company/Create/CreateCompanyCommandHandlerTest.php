<?php

declare(strict_types=1);

namespace Tests\Integration\App\Commands\Company\Create;

use App\Commands\Company\Create\CreateCompanyCommand;
use App\Commands\Company\Create\CreateCompanyCommandHandler;
use Domains\Company\Response\CompanyResponse;
use Domains\User\Models\User;
use Tests\FeatureIntegrationTestCase;

final class CreateCompanyCommandHandlerTest extends FeatureIntegrationTestCase
{
    private CreateCompanyCommandHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var CreateCompanyCommandHandler $handler */
        $handler = $this->app->make(CreateCompanyCommandHandler::class);
        $this->handler = $handler;

        /** @var User $user */
        $user = User::factory()->create();
        $this->user = $user;
    }

    public function testInvokeReturnSuccess(): void
    {
        $command = CreateCompanyCommand::fromArray([
            'name' => 'Company Name',
            'description' => 'Company Description',
            'companyOwnerId' => $this->user->id,
        ]);

        $response = $this->handler->__invoke($command);

        $this->assertInstanceOf(CompanyResponse::class, $response);
        $this->assertSame('Company Name', $response->getName());
        $this->assertSame('Company Description', $response->getDescription());
        $this->assertEquals($response->getCompanyOwner(), $this->user->toArray());
    }

    public function testInvokeReturnSuccessWithoutCompanyOwnerId(): void
    {
        $command = CreateCompanyCommand::fromArray([
            'name' => 'Company Name',
            'description' => 'Company Description',
        ]);

        $this->actingAs($this->user);

        $response = $this->handler->__invoke($command);

        $this->assertInstanceOf(CompanyResponse::class, $response);
        $this->assertSame('Company Name', $response->getName());
        $this->assertSame('Company Description', $response->getDescription());
        $this->assertEquals($response->getCompanyOwner(), $this->user->toArray());
    }
}
