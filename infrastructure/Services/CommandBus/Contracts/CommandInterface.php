<?php

declare(strict_types=1);

namespace Infrastructure\Services\CommandBus\Contracts;

use Illuminate\Foundation\Http\FormRequest;

interface CommandInterface
{
    public static function fromValidatedRequest(FormRequest $request): static;
}
