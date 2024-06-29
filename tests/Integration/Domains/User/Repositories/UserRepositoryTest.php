<?php

declare(strict_types=1);

namespace Tests\Integration\Domains\User\Repositories;

use Domains\User\Contracts\UserRepositoryInterface;
use Domains\User\DTO\CreateUserPayload;
use Domains\User\DTO\UpdateUserPayload;
use Domains\User\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\FeatureIntegrationTestCase;

final class UserRepositoryTest extends FeatureIntegrationTestCase
{
    private UserRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var UserRepositoryInterface $repository */
        $repository = $this->app->make(UserRepositoryInterface::class);
        $this->repository = $repository;
    }

    public function testCreate(): void
    {
        $user = $this->repository->create(
            CreateUserPayload::fromArray([
                'name' => 'John Doe',
                'email' => 'test@example.org',
                'password' => 'password',
            ])
        );

        $this->assertInstanceOf(User::class, $user);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'John Doe',
            'email' => 'test@example.org',
        ]);
    }

    public function testUpdated(): void
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'test@example.org',
        ]);

        $response = $this->repository->update(
            $user,
            UpdateUserPayload::fromArray([
                ...$user->toArray(),
                'name' => 'Jane Doe',
                'email' => 'test2@example.org',
            ])
        );

        $this->assertInstanceOf(User::class, $response);
        $this->assertSame('Jane Doe', $response->name);
        $this->assertSame('test2@example.org', $response->email);

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
            'name' => 'John Doe',
            'email' => 'test@example.org',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Jane Doe',
            'email' => 'test2@example.org',
        ]);
    }

    public function testDelete(): void
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'test@example.org',
        ]);

        $this->repository->delete($user);

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
            'name' => 'John Doe',
            'email' => 'test@example.org',
        ]);
    }

    public function testFind(): void
    {
        $user = User::factory()->create();

        $foundUser = $this->repository->find($user->id);

        $this->assertInstanceOf(User::class, $foundUser);

        $this->assertSame($user->id, $foundUser->id);
        $this->assertSame($user->name, $foundUser->name);
        $this->assertSame($user->email, $foundUser->email);
    }

    public function testSearch(): void
    {
        User::factory()->create();

        $foundUser = $this->repository->search();

        $this->assertInstanceOf(LengthAwarePaginator::class, $foundUser);
        $this->assertInstanceof(User::class, $foundUser->first());
    }

    public function testGet(): void
    {
        $user = User::factory()->create();

        $foundUser = $this->repository->get([
            'email' => $user->email,
        ]);

        $this->assertInstanceOf(Collection::class, $foundUser);
        $this->assertInstanceof(User::class, $foundUser->first());
        $this->assertSame($user->id, $foundUser->first()->id);
        $this->assertSame($user->name, $foundUser->first()->name);
        $this->assertSame($user->email, $foundUser->first()->email);
    }
}
