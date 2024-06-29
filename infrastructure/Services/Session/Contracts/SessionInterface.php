<?php

declare(strict_types=1);

namespace Infrastructure\Services\Session\Contracts;

use Domains\User\Models\User;

interface SessionInterface
{
    public function get(): ?User;
}
