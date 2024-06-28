<?php

declare(strict_types=1);

namespace Infrastructure\Services\Shared\Traits;

trait BusMapper
{
    /**
     * @param array<class-string,class-string> $map
     */
    public function map(array $map): void
    {
        $this->bus->map($map);
    }
}
