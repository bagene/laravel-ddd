<?php

declare(strict_types=1);

namespace Tests\Feature\Infrastructure\Services\CommandBus\Bus;

use App\Shared\Traits\StaticConstructor;
use Infrastructure\Services\CommandBus\Contracts\CommandBusInterface;
use Infrastructure\Services\CommandBus\Contracts\CommandInterface;
use Infrastructure\Services\CommandBus\Exceptions\CommandNotFoundException;
use Infrastructure\Services\QueryBus\Contracts\QueryBusInterface;
use Infrastructure\Services\QueryBus\Contracts\QueryInterface;
use Infrastructure\Services\QueryBus\Exceptions\QueryNotFoundException;
use Tests\FeatureIntegrationTestCase;
use Tests\Shared\CommandBus\ExampleCommand\TestCommand;
use Tests\Shared\CommandBus\ExampleCommand\TestCommandHandler;
use Tests\Shared\CommandBus\ExampleResponse\TestCommandResponse;
use Tests\Shared\QueryBus\ExampleQuery\TestQuery;
use Tests\Shared\QueryBus\ExampleResponse\TestQueryResponse;

final class CommandBusTest extends FeatureIntegrationTestCase
{
    private CommandBusInterface $bus;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var CommandBusInterface $bus */
        $bus = $this->app->make(CommandBusInterface::class);

        $bus->map([
            TestCommand::class => TestCommandHandler::class
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

        $this->bus->dispatch(new class implements CommandInterface {
            use StaticConstructor;
        });
    }
}
