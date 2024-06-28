<?php

declare(strict_types=1);

namespace Infrastructure\Services\QueryBus\Contracts;

interface QueryBusInterface
{
    public function ask(QueryInterface $query): QueryResponseInterface;

    /**
     * @param array<class-string,class-string> $map
     */
    public function map(array $map): void;
}
