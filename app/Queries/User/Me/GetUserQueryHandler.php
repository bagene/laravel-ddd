<?php

declare(strict_types=1);

namespace App\Queries\User\Me;

use App\Shared\Response\ErrorResponse;
use App\Shared\Response\UserResponse;
use Domains\User\Models\User;
use Infrastructure\Services\Session\Contracts\SessionInterface;

final class GetUserQueryHandler
{
    public function __construct(private readonly SessionInterface $session) {}

    public function __invoke(GetUserQuery $command): UserResponse|ErrorResponse
    {
        /** @var User $user */
        $user = $this->session->get();

        return UserResponse::fromModel($user);
    }
}
