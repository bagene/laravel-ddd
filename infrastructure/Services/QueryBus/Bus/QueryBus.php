<?php

declare(strict_types=1);

namespace Infrastructure\Services\QueryBus\Bus;

use Illuminate\Bus\Dispatcher;
use Infrastructure\Services\QueryBus\Contracts\QueryBusInterface;
use Infrastructure\Services\QueryBus\Contracts\QueryInterface;
use Infrastructure\Services\QueryBus\Contracts\QueryResponseInterface;
use Infrastructure\Services\QueryBus\Exceptions\QueryNotFoundException;
use Infrastructure\Services\Shared\Traits\BusMapper;

final readonly class QueryBus implements QueryBusInterface
{
    use BusMapper;

    public function __construct(private Dispatcher $bus)
    {
    }

    /**
     * @throws QueryNotFoundException
     */
    public function ask(QueryInterface $query): QueryResponseInterface
    {
        if (!$this->bus->getCommandHandler($query)) {
            throw new QueryNotFoundException('Query Handler not found');
        }

        /** @var QueryResponseInterface $response */
        $response = $this->bus->dispatch($query);

        return $response;
    }
}
