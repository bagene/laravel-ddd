<?php

declare(strict_types=1);

namespace Infrastructure\Services\QueryBus\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Infrastructure\Services\QueryBus\Bus\QueryBus;
use Infrastructure\Services\QueryBus\Contracts\QueryBusInterface;

class QueryBusServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            QueryBusInterface::class,
            QueryBus::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->mapQueries();
    }

    private function mapQueries(): void
    {
        $queryPath = app_path('Queries');
        $queries = glob("$queryPath/**/**/*Query.php") ?: [];
        $queries = array_map(
            fn ($dir) => Str::replace('/', '\\', 'App/'.Str::after($dir, 'app/')),
            $queries,
        );
        $map = [];

        foreach ($queries as $file) {
            $queryClass = basename($file, '.php');
            $handlerClass = $queryClass.'Handler';

            if (class_exists($queryClass) && class_exists($handlerClass)) {
                $map[$queryClass] = $handlerClass;
            }
        }

        $queryBus = $this->app->make(QueryBusInterface::class);

        if ($queryBus instanceof QueryBusInterface) {
            $queryBus->map($map);
        }
    }
}
