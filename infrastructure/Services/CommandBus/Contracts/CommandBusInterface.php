<?php

declare(strict_types=1);

namespace Infrastructure\Services\CommandBus\Contracts;

interface CommandBusInterface
{
    public function dispatch(CommandInterface $command): ?CommandResponseInterface;

    /**
     * @param array<class-string,class-string> $map
     */
    public function map(array $map): void;
}
