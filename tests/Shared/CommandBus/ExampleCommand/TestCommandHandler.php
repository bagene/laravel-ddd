<?php

declare(strict_types=1);

namespace Tests\Shared\CommandBus\ExampleCommand;

use Tests\Shared\CommandBus\ExampleResponse\TestCommandResponse;

final class TestCommandHandler
{
    public function __invoke(TestCommand $query): TestCommandResponse
    {
        return new TestCommandResponse();
    }
}
