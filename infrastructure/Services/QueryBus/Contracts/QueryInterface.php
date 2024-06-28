<?php

declare(strict_types=1);

namespace Infrastructure\Services\QueryBus\Contracts;

use Illuminate\Http\Request;

interface QueryInterface
{
    public static function fromQueryParameters(Request $request): static;
}
