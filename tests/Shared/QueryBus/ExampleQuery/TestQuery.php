<?php

declare(strict_types=1);

namespace Tests\Shared\QueryBus\ExampleQuery;

use App\Shared\Traits\StaticConstructor;
use Infrastructure\Services\QueryBus\Contracts\QueryInterface;

final class TestQuery implements QueryInterface
{
    use StaticConstructor;
}
