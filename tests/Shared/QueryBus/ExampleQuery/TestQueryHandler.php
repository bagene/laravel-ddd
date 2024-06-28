<?php

declare(strict_types=1);

namespace Tests\Shared\QueryBus\ExampleQuery;

use Tests\Shared\QueryBus\ExampleResponse\TestQueryResponse;

final class TestQueryHandler
{
    public function __invoke(TestQuery $query): TestQueryResponse
    {
        return new TestQueryResponse();
    }
}
