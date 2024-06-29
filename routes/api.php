<?php

$domainPath = base_path('domains');
$domains = array_map(
    fn ($dir) => basename($dir),
    glob("$domainPath/*", GLOB_ONLYDIR) ?: []
);

foreach ($domains as $domain) {
    $routes = glob("$domainPath/$domain/routes/*.php") ?: [];

    foreach ($routes as $route) {
        require $route;
    }
}
