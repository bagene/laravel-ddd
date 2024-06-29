<?php

declare(strict_types=1);

namespace App\Queries\User\Me;

use App\Shared\Traits\StaticConstructor;
use App\Shared\Traits\ToArray;
use Infrastructure\Services\QueryBus\Contracts\QueryInterface;

final class GetUserQuery implements QueryInterface
{
    use StaticConstructor, ToArray;

    public function __construct() {}
}
