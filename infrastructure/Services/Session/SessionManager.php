<?php

declare(strict_types=1);

namespace Infrastructure\Services\Session;

use Domains\User\Models\User;
use Infrastructure\Services\Session\Contracts\SessionInterface;

final class SessionManager implements SessionInterface
{
    public function get(): ?User
    {
        /** @var User $user */
        $user = auth()->user();

        return $user;
    }
}
