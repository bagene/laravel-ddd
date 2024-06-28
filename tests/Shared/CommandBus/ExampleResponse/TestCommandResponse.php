<?php

declare(strict_types=1);

namespace Tests\Shared\CommandBus\ExampleResponse;

use App\Shared\Traits\ToArray;
use Infrastructure\Services\CommandBus\Contracts\CommandResponseInterface;

final class TestCommandResponse implements CommandResponseInterface
{
    use ToArray;
}
