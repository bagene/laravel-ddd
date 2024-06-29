<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

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
