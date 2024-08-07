<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Tests\FeatureIntegrationTestCase;

class DocsTest extends FeatureIntegrationTestCase
{
    private const EXCLUDED_ROUTES = [
        'sanctum/csrf-cookie',
        'up',
    ];

    public function testEndpointsHasDocs(): void
    {
        $this->artisan('scribe:generate');

        $json = file_get_contents(public_path('docs/collection.json'));
        $collection = json_decode($json, true);

        $endpoints = $this->getEndpointsFromArray($collection);

        foreach (Route::getRoutes() as $route) {
            $uri = $route->uri;
            $method = $route->methods[0];
            $routeParams = $route->parameterNames();

            foreach ($routeParams as $param) {
                $uri = Str::replaceFirst("{{$param}}", ":$param", $uri);
            }

            if ($method === 'HEAD' || in_array($uri, self::EXCLUDED_ROUTES)) {
                continue;
            }

            $this->assertContains("$method $uri", $endpoints, "Endpoint $method $uri has no documentation");
        }
    }

    private function getEndpointsFromArray(array $data, array $endpoints = []): array
    {
        foreach ($data['item'] as $item) {
            $url = data_get($item, 'request.url.path');
            if ($url) {
                $method = data_get($item, 'request.method');
                $endpoints[] = "$method $url";
            }

            if (isset($item['item'])) {
                $endpoints = $this->getEndpointsFromArray($item, $endpoints);
            }
        }

        return $endpoints;
    }
}
