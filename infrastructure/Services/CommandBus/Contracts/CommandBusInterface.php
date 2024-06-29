<?php

declare(strict_types=1);

namespace Infrastructure\Services\CommandBus\Contracts;

use App\Shared\Response\ErrorResponse;

interface CommandBusInterface
{
    public function dispatch(CommandInterface $command): CommandResponseInterface|ErrorResponse|null;

    /**
     * @param  array<class-string,class-string>  $map
     */
    public function map(array $map): void;
}
