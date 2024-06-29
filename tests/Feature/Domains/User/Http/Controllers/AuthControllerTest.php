<?php

declare(strict_types=1);

namespace Tests\Feature\Domains\User\Http\Controllers;

use Domains\User\Models\User;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\FeatureIntegrationTestCase;

final class AuthControllerTest extends FeatureIntegrationTestCase
{
    private const LOGIN_URI = '/api/login';

    private const USER_URI = '/api/users/me';

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var User $user */
        $user = User::factory()->create([
            'email' => 'test@example.org',
            'password' => 'password',
        ]);
        $this->user = $user;
    }

    public function testLoginReturnSuccess(): void
    {
        $response = $this->json(self::POST_METHOD, self::LOGIN_URI, [
            'email' => 'test@example.org',
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'token',
            ],
        ]);
    }

    public function testLoginReturnInvalidCredentials(): void
    {
        $response = $this->json(self::POST_METHOD, self::LOGIN_URI, [
            'email' => 'test2@example.org',
            'password' => 'password',
        ]);

        $response->assertStatus(401);
        $response->assertJson([
            'data' => [
                'message' => 'Invalid credentials',
                'code' => 401,
            ],
        ]);
    }

    #[DataProvider('providerInvalidData')]
    public function testLoginReturnInvalidData(array $payload, array $expectedErrors, int $expectedStatusCode): void
    {
        $response = $this->json(self::POST_METHOD, self::LOGIN_URI, $payload);

        $response->assertStatus($expectedStatusCode);
        $response->assertJsonValidationErrors($expectedErrors);
    }

    public static function providerInvalidData(): array
    {
        return [
            'empty' => [
                [],
                [
                    'email' => ['The email field is required.'],
                    'password' => ['The password field is required.'],
                ],
                422,
            ],
            'invalidEmail' => [
                [
                    'email' => 'invalid',
                    'password' => 'password',
                ],
                [
                    'email' => ['The email field must be a valid email address.'],
                ],
                422,
            ],
        ];
    }

    public function testGetUserReturnSuccess(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->json(self::GET_METHOD, self::USER_URI);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email',
                'email_verified_at',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    public function testGetUserReturnUnauthorized(): void
    {
        $response = $this->json(self::GET_METHOD, self::USER_URI);

        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Unauthenticated.',
        ]);
    }
}
