<?php

declare(strict_types=1);

namespace Infrastructure\Services\CommandBus\Providers;

use Infrastructure\Services\CommandBus\Bus\CommandBus;
use Illuminate\Support\ServiceProvider;
use Infrastructure\Services\CommandBus\Contracts\CommandBusInterface;
use Illuminate\Support\Str;

class CommandBusServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(
            abstract: CommandBusInterface::class,
            concrete: CommandBus::class,
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->mapCommands();
    }

    private function mapCommands(): void
    {
        $commandPath = app_path('Commands');
        $commands = glob("$commandPath/**/**/*Command.php") ?: [];
        $commands = array_map(
            fn ($dir) => Str::replace('/', "\\", 'App/' . Str::after($dir, 'app/')),
            $commands,
        );
        $map = [];

        foreach ($commands as $file) {
            $commandClass = basename($file, '.php');
            $handlerClass = $commandClass . 'Handler';

            if (class_exists($commandClass) && class_exists($handlerClass)) {
                $map[$commandClass] = $handlerClass;
            }
        }

        $commandBus = $this->app->make(CommandBusInterface::class);

        if ($commandBus instanceof CommandBusInterface) {
            $commandBus->map($map);
        }
    }
}
