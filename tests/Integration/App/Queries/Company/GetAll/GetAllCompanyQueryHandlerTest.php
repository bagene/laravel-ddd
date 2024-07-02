<?php

declare(strict_types=1);

namespace Tests\Integration\App\Queries\Company\GetAll;

use App\Queries\Company\GetAll\GetAllCompanyQuery;
use App\Queries\Company\GetAll\GetAllCompanyQueryHandler;
use Domains\Company\Models\Company;
use Domains\User\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Tests\FeatureIntegrationTestCase;

final class GetAllCompanyQueryHandlerTest extends FeatureIntegrationTestCase
{
    private const COUNT = 10;

    private GetAllCompanyQueryHandler $handler;

    protected static User $adminUser;

    private Collection $companies;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setAuth();

        /** @var GetAllCompanyQueryHandler $handler */
        $handler = $this->app->make(GetAllCompanyQueryHandler::class);
        $this->handler = $handler;

        /** @var Collection<Company> $companies */
        $companies = Company::factory()
            ->count(self::COUNT)
            ->create([
                'company_owner_id' => $this::$adminUser->id,
            ]);
        $this->companies = $companies;

        $this->actingAs($this::$adminUser);
    }

    public function testInvokeReturnSuccess(): void
    {
        $response = $this->handler->__invoke(
            GetAllCompanyQuery::fromArray([])
        );

        $this->assertMatchesPattern([
            'data' => '@array@',
            'first_page_url' => '@string@',
            'from' => '@integer@',
            'last_page' => '@integer@',
            'last_page_url' => '@string@',
            'links' => '@array@',
            'next_page_url' => '@null@',
            'path' => '@string@',
            'per_page' => '@integer@',
            'prev_page_url' => '@null@',
            'total' => self::COUNT,
            'to' => '@integer@',
            'current_page' => '@integer@',
        ], $response->toArray());

        $this->assertMatchesPattern([
            'id' => '@uuid@',
            'name' => '@string@',
            'description' => '@string@',
            'company_owner_id' => '@uuid@',
            'created_at' => '@string@',
            'updated_at' => '@string@',
            'company_owner' => '@array@',
        ], $response->getData()[0]);

        $this->assertSame(self::COUNT, $response->toArray()['total']);
        $this->assertEquals($this->companies->load('company_owner')->toArray(), $response->getData());
    }

    public function testInvokeWithNameFilter(): void
    {
        $targetCompany = $this->companies->random();

        $response = $this->handler->__invoke(
            GetAllCompanyQuery::fromArray([
                'name' => $targetCompany->name,
            ])
        );

        $resultData = $response->getData()[0];

        $this->assertSame(1, $response->toArray()['total']);
        $this->assertEquals($targetCompany->load('company_owner')->toArray(), $resultData);
    }

    public function testInvokeWithDescriptionFilter(): void
    {
        $targetCompany = $this->companies->random();

        $response = $this->handler->__invoke(
            GetAllCompanyQuery::fromArray([
                'description' => $targetCompany->description,
            ])
        );

        $resultData = $response->getData()[0];

        $this->assertSame(1, $response->toArray()['total']);
        $this->assertEquals($targetCompany->load('company_owner')->toArray(), $resultData);
    }

    public function testInvokeWithCompanyOwnerIdFilter(): void
    {
        $response = $this->handler->__invoke(
            GetAllCompanyQuery::fromArray([
                'company_owner_id' => $this::$adminUser->id,
            ])
        );

        $this->assertSame(self::COUNT, $response->toArray()['total']);
        $this->assertEquals($this->companies->load('company_owner')->toArray(), $response->getData());
    }
}
