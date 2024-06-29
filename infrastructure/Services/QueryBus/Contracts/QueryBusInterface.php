<?php

declare(strict_types=1);

namespace Infrastructure\Services\QueryBus\Contracts;

use App\Shared\Response\ErrorResponse;

interface QueryBusInterface
{
    public function ask(QueryInterface $query): QueryResponseInterface|ErrorResponse;

    /**
     * @param  array<class-string,class-string>  $map
     */
    public function map(array $map): void;
}
