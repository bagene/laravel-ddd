<?php

declare(strict_types=1);

namespace App\Shared;

use App\Shared\Traits\ToArray;
use Infrastructure\Services\CommandBus\Contracts\CommandInterface;

abstract class AbstractCommand implements CommandInterface
{
    use ToArray;
}
