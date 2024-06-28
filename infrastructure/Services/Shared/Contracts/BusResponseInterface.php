<?php

declare(strict_types=1);

namespace Infrastructure\Services\Shared\Contracts;

interface BusResponseInterface
{
    /**
     * @return array<string,mixed>
     */
    public function toArray(): array;
}
