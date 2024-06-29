<?php

declare(strict_types=1);

namespace Tests\Integration\Infrastructure\Services\QueryBus\Bus;

use App\Shared\Traits\StaticConstructor;
use Infrastructure\Services\QueryBus\Contracts\QueryBusInterface;
use Infrastructure\Services\QueryBus\Contracts\QueryInterface;
use Infrastructure\Services\QueryBus\Exceptions\QueryNotFoundException;
use Tests\FeatureIntegrationTestCase;
use Tests\Shared\QueryBus\ExampleQuery\TestQuery;
use Tests\Shared\QueryBus\ExampleQuery\TestQueryHandler;
use Tests\Shared\QueryBus\ExampleResponse\TestQueryResponse;

final class QueryBusTest extends FeatureIntegrationTestCase
{
    private QueryBusInterface $bus;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var QueryBusInterface $bus */
        $bus = $this->app->make(QueryBusInterface::class);

        $bus->map([
            TestQuery::class => TestQueryHandler::class,
        ]);

        $this->bus = $bus;
    }

    public function testAsk(): void
    {
        $response = $this->bus->ask(new TestQuery());

        $this->assertInstanceOf(TestQueryResponse::class, $response);
    }

    public function testAskQueryNotFound(): void
    {
        $this->expectException(QueryNotFoundException::class);
        $this->expectExceptionMessage('Query Handler not found');

        $this->bus->ask(new class implements QueryInterface
        {
            use StaticConstructor;
        });
    }
}
