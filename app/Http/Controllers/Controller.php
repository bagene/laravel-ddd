<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Shared\Response\ErrorResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Infrastructure\Services\CommandBus\Contracts\CommandBusInterface;
use Infrastructure\Services\CommandBus\Contracts\CommandInterface;
use Infrastructure\Services\QueryBus\Contracts\QueryBusInterface;
use Infrastructure\Services\QueryBus\Contracts\QueryInterface;

abstract class Controller
{
    protected const COMMAND_CLASS = CommandInterface::class;

    protected const QUERY_CLASS = QueryInterface::class;

    public function __construct(
        protected readonly CommandBusInterface $commandBus,
        protected readonly QueryBusInterface $queryBus
    ) {}

    /**
     * @param  class-string<CommandInterface>  $commandClass
     */
    protected function dispatch(?FormRequest $request = null, string $commandClass = self::COMMAND_CLASS): ?JsonResponse
    {
        $command = $request !== null ?
            $commandClass::fromValidatedRequest($request)
            : new $commandClass();

        $status = 200;
        $response = $this->commandBus->dispatch($command);

        if ($response instanceof ErrorResponse) {
            $status = $response->getCode();
        }

        return response()->json([
            'data' => $response?->toArray(),
        ], $status);
    }

    /**
     * @param  class-string<QueryInterface>  $queryClass
     */
    protected function ask(string $queryClass = self::QUERY_CLASS, bool $wrapInData = true, bool $fromQuery = false): JsonResponse
    {
        $query = $fromQuery ?
            $queryClass::fromQueryParameters(request())
            : new $queryClass();

        $response = $this->queryBus->ask($query);

        $status = 200;

        if ($response instanceof ErrorResponse) {
            $status = $response->getCode();
        }

        return response()->json([
            'data' => $response->toArray(),
        ], $status);
    }
}
