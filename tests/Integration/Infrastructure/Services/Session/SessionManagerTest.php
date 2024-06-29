<?php

declare(strict_types=1);

namespace Tests\Integration\Infrastructure\Services\Session;

use Domains\User\Models\User;
use Infrastructure\Services\Session\Contracts\SessionInterface;
use Tests\FeatureIntegrationTestCase;

final class SessionManagerTest extends FeatureIntegrationTestCase
{
    private SessionInterface $sessionRepository;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var SessionInterface $session */
        $session = $this->app->make(SessionInterface::class);
        $this->sessionRepository = $session;
    }

    public function testGetReturnUser(): void
    {
        $this->actingAs(User::factory()->create());

        $this->assertInstanceOf(User::class, $this->sessionRepository->get());
    }

    public function testGetReturnNull(): void
    {
        $this->assertNull($this->sessionRepository->get());
    }
}
