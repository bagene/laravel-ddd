<?php

declare(strict_types=1);

namespace Infrastructure\Services\Session\Providers;

use Illuminate\Support\ServiceProvider;
use Infrastructure\Services\Session\Contracts\SessionInterface;
use Infrastructure\Services\Session\SessionManager;

class SessionProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->singleton(
            SessionInterface::class,
            SessionManager::class,
        );
    }
}
