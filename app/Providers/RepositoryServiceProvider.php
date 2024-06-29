<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Automatically register repositories for each domain
        $this->registerRepositories();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    private function registerRepositories(): void
    {
        $domainPath = base_path('domains');
        $domains = array_map(
            fn ($dir) => basename($dir),
            glob("$domainPath/*", GLOB_ONLYDIR) ?: []
        );

        foreach ($domains as $domain) {
            $repositories = glob("$domainPath/$domain/Repositories/*.php") ?: [];

            foreach ($repositories as $repository) {
                $repositoryName = basename($repository, '.php');

                $this->app->bind(
                    "Domains\\$domain\\Contracts\\{$repositoryName}Interface",
                    "Domains\\$domain\\Repositories\\$repositoryName",
                );
            }
        }
    }
}
