<?php

declare(strict_types=1);

namespace App\Queries\Company\Get;

use App\Shared\Traits\StaticConstructor;
use App\Shared\Traits\ToArray;
use Infrastructure\Services\QueryBus\Contracts\QueryInterface;

final class GetCompanyQuery implements QueryInterface
{
    use StaticConstructor, ToArray;

    public function __construct(
        private readonly string $id
    ) {}

    public function getId(): string
    {
        return $this->id;
    }
}
