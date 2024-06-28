<?php

declare(strict_types=1);

namespace App\Shared\Response;

use App\Shared\Traits\ToArray;
use Infrastructure\Services\CommandBus\Contracts\CommandResponseInterface;
use Infrastructure\Services\QueryBus\Contracts\QueryResponseInterface;

final class ErrorResponse implements CommandResponseInterface, QueryResponseInterface
{
    use ToArray;

    private function __construct(
        private readonly string $message,
        private readonly int $code,
    ) {}

    public static function create(string $message, int $code): self
    {
        return new self($message, $code);
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getCode(): int
    {
        return $this->code;
    }
}
