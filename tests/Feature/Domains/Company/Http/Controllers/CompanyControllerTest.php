<?php

declare(strict_types=1);

namespace Tests\Feature\Domains\Company\Http\Controllers;

use Domains\Company\Models\Company;
use Domains\User\Models\User;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\FeatureIntegrationTestCase;

final class CompanyControllerTest extends FeatureIntegrationTestCase
{
    private const CREATE_COMPANY_URI = '/api/companies';

    private const GET_COMPANIES_URI = '/api/companies';

    private const GET_COMPANY_URI = '/api/companies/{id}';

    private const UPDATE_COMPANY_URI = '/api/companies/{id}';

    public function testCreateCompanyReturnSuccess(): void
    {
        $user = User::factory()->create();
        $response = $this->json(self::POST_METHOD, self::CREATE_COMPANY_URI, [
            'name' => 'Company Name',
            'description' => 'Company Description',
            'company_owner_id' => $user->id,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'description',
                'company_owner' => [
                    'id',
                    'name',
                    'email',
                    'email_verified_at',
                    'created_at',
                    'updated_at',
                ],
                'created_at',
                'updated_at',
            ],
        ]);
    }

    #[DataProvider('provideInvalidData')]
    public function testCreateCompanyReturnError(array $data, array $errors): void
    {
        $response = $this->json(self::POST_METHOD, self::CREATE_COMPANY_URI, $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors($errors);
    }

    public static function provideInvalidData(): array
    {
        return [
            'empty' => [
                [],
                [
                    'name' => ['The name field is required.'],
                    'description' => ['The description field is required.'],
                ],
            ],
            'name is required' => [
                [
                    'description' => 'Company Description',
                ],
                [
                    'name' => ['The name field is required.'],
                ],
            ],
            'description is required' => [
                [
                    'name' => 'Company Name',
                ],
                [
                    'description' => ['The description field is required.'],
                ],
            ],
        ];
    }

    public function testGetAllCompaniesReturnSuccess(): void
    {
        $response = $this->json(self::GET_METHOD, self::GET_COMPANIES_URI);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'description',
                    'company_owner' => [
                        'id',
                        'name',
                        'email',
                        'email_verified_at',
                        'created_at',
                        'updated_at',
                    ],
                    'created_at',
                    'updated_at',
                ],
            ],
            'first_page_url',
            'from',
            'last_page',
            'last_page_url',
            'links' => [
                '*' => [
                    'url',
                    'label',
                    'active',
                ],
            ],
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'total',
            'to',
            'current_page',
        ]);
    }

    public function testGetCompanyReturnSuccess(): void
    {
        $this->setAuth();
        $company = Company::factory()->create(
            ['company_owner_id' => $this::$adminUser->id]
        );
        $response = $this->json(
            self::GET_METHOD,
            strtr(self::GET_COMPANY_URI, ['{id}' => $company->id])
        );

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'description',
                'company_owner' => [
                    'id',
                    'name',
                    'email',
                    'email_verified_at',
                    'created_at',
                    'updated_at',
                ],
                'created_at',
                'updated_at',
            ],
        ]);
    }

    public function testGetReturnNotFound(): void
    {
        $this->setAuth();
        $response = $this->json(
            self::GET_METHOD,
            strtr(self::GET_COMPANY_URI, ['{id}' => 'invalid-id'])
        );

        $response->assertStatus(404);
        $response->assertJsonStructure([
            'data' => [
                'message',
                'code',
            ],
        ]);
    }

    public function testUpdateReturnSuccess(): void
    {
        $this->setAuth();
        $company = Company::factory()->create(
            ['company_owner_id' => $this::$adminUser->id]
        );
        $response = $this->json(
            self::PUT_METHOD,
            strtr(self::UPDATE_COMPANY_URI, ['{id}' => $company->id]),
            [
                'name' => 'New Company Name',
                'description' => 'New Company Description',
                'company_owner_id' => $this::$adminUser->id,
            ]
        );

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'description',
                'company_owner' => [
                    'id',
                    'name',
                    'email',
                    'email_verified_at',
                    'created_at',
                    'updated_at',
                ],
                'created_at',
                'updated_at',
            ],
        ]);

        $this->assertDatabaseMissing('companies', [
            'id' => $company->id,
            'name' => $company->name,
            'description' => $company->description,
        ]);

        $this->assertDatabaseHas('companies', [
            'id' => $company->id,
            'name' => 'New Company Name',
            'description' => 'New Company Description',
        ]);
    }

    public function testUpdateReturnNotFound(): void
    {
        $this->setAuth();
        $response = $this->json(
            self::PUT_METHOD,
            strtr(self::UPDATE_COMPANY_URI, ['{id}' => 'invalid-id']),
            [
                'name' => 'New Company Name',
                'description' => 'New Company Description',
                'company_owner_id' => $this::$adminUser->id,
            ]
        );

        $response->assertStatus(404);
        $response->assertJsonStructure([
            'data' => [
                'message',
                'code',
            ],
        ]);
    }

    #[DataProvider('providerUpdateInvalidData')]
    public function testUpdateCompanyReturnError(array $data, array $errors): void
    {
        $response = $this->json(self::PUT_METHOD, self::UPDATE_COMPANY_URI, $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors($errors);
    }

    public static function providerUpdateInvalidData(): array
    {
        return [
            'empty' => [
                [],
                [
                    'name' => ['The name field is required.'],
                    'description' => ['The description field is required.'],
                ],
            ],
            'name is required' => [
                [
                    'description' => 'Company Description',
                ],
                [
                    'name' => ['The name field is required.'],
                ],
            ],
            'description is required' => [
                [
                    'name' => 'Company Name',
                ],
                [
                    'description' => ['The description field is required.'],
                ],
            ],
        ];
    }
}
