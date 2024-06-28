<?php

declare(strict_types=1);

namespace Tests\Shared\QueryBus\ExampleResponse;

use App\Shared\Traits\ToArray;
use Infrastructure\Services\QueryBus\Contracts\QueryResponseInterface;

final class TestQueryResponse implements QueryResponseInterface
{
    use ToArray;
}
