<?php

declare(strict_types=1);

namespace App\Shared;

use App\Shared\Traits\ToArray;
use Infrastructure\Services\QueryBus\Contracts\QueryInterface;

abstract class AbstractQuery implements QueryInterface
{
    use ToArray;
}
