<?php

declare(strict_types=1);

namespace Tests\Feature\Domains\Company\Http\Controllers;

use Domains\User\Models\User;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\FeatureIntegrationTestCase;

final class CompanyControllerTest extends FeatureIntegrationTestCase
{
    private const CREATE_COMPANY_URI = '/api/companies';

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
}
