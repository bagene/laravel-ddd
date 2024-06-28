<?php

declare(strict_types=1);

namespace Tests\Shared\CommandBus\ExampleCommand;

use App\Shared\Traits\StaticConstructor;
use Infrastructure\Services\CommandBus\Contracts\CommandInterface;

final class TestCommand implements CommandInterface
{
    use StaticConstructor;
}
