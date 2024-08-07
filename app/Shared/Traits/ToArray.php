<?php

declare(strict_types=1);

namespace App\Shared\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait ToArray
{
    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        $result = [];

        $reflection = new \ReflectionClass($this);
        foreach ($reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
            $methodName = $method->getName();
            if ($method->isConstructor() || $method->isAbstract() || $method->isStatic() || $methodName === 'toArray') {
                continue;
            }

            $key = lcfirst(ltrim($methodName, 'get') ?: ltrim($methodName, 'is'));
            $result[Str::snake($key)] = $this->$methodName();

            if ($result[Str::snake($key)] instanceof Model) {
                $result[Str::snake($key)] = $result[Str::snake($key)]->toArray();
            }
        }

        return $result;
    }
}
