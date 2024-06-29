<?php

declare(strict_types=1);

namespace Tests\Integration\Infrastructure\Services\CommandBus\Bus;

use App\Shared\Traits\StaticConstructor;
use Infrastructure\Services\CommandBus\Contracts\CommandBusInterface;
use Infrastructure\Services\CommandBus\Contracts\CommandInterface;
use Infrastructure\Services\CommandBus\Exceptions\CommandNotFoundException;
use Tests\FeatureIntegrationTestCase;
use Tests\Shared\CommandBus\ExampleCommand\TestCommand;
use Tests\Shared\CommandBus\ExampleCommand\TestCommandHandler;
use Tests\Shared\CommandBus\ExampleResponse\TestCommandResponse;

final class CommandBusTest extends FeatureIntegrationTestCase
{
    private CommandBusInterface $bus;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var CommandBusInterface $bus */
        $bus = $this->app->make(CommandBusInterface::class);

        $bus->map([
            TestCommand::class => TestCommandHandler::class,
        ]);

        $this->bus = $bus;
    }

    public function testAsk(): void
    {
        $response = $this->bus->dispatch(new TestCommand());

        $this->assertInstanceOf(TestCommandResponse::class, $response);
    }

    public function testAskQueryNotFound(): void
    {
        $this->expectException(CommandNotFoundException::class);
        $this->expectExceptionMessage('Command Handler not found');

        $this->bus->dispatch(new class implements CommandInterface
        {
            use StaticConstructor;
        });
    }
}
