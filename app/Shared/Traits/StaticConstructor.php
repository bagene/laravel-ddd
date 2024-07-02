<?php

declare(strict_types=1);

namespace App\Shared\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Str;

/**
 * Trait StaticConstructor
 */
trait StaticConstructor
{
    /**
     * @param  array<string,mixed>  $data
     */
    public static function fromArray(array $data): static
    {
        return new static(...static::mapFields($data));
    }

    public static function fromModel(Model $model): static
    {
        return new static(...static::mapFields($model->toArray()));
    }

    public static function fromValidatedRequest(FormRequest $request): static
    {
        /** @var array<string,mixed> $routeParams */
        $routeParams = $request->route()?->parameters();

        return static::fromArray([
            ...$routeParams,
            ...$request->validated(),
        ]);
    }

    public static function fromQueryParameters(Request $request): static
    {
        /** @var Route $route */
        $route = $request->route();
        /** @var array<string,mixed> $queries */
        $queries = $request->query() ?: $route->parameters();

        return static::fromArray($queries);
    }

    /**
     * @param  array<string,mixed>  $data
     * @return array<string,mixed>
     */
    protected static function mapFields(array $data): array
    {
        $reflection = new \ReflectionClass(static::class);

        $result = [];

        /** @var \ReflectionMethod $constructor */
        $constructor = $reflection->getConstructor();
        $arguments = $constructor->getParameters();

        if (count($arguments) === 0) {
            return [];
        }

        foreach ($arguments as $argument) {
            /** @var string $type */
            $type = $argument->getType()?->__toString();
            $type = Str::replace('?', '', $type);
            $default = $argument->isDefaultValueAvailable() ? $argument->getDefaultValue() : null;
            $key = Str::camel($argument->getName());
            $result[$key] = $data[Str::snake($key)] ?? $data[$key] ?? $default;
            $result[$key] = match ($type) {
                'int' => (int) $result[$key],
                'float' => (float) $result[$key],
                'bool' => (bool) $result[$key],
                default => $result[$key],
            };
        }

        return $result;
    }
}
