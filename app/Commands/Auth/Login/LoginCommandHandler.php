<?php

declare(strict_types=1);

namespace App\Commands\Auth\Login;

use App\Shared\Response\ErrorResponse;
use Domains\User\Contracts\UserRepositoryInterface;
use Domains\User\Models\User;
use Domains\User\Response\LoginResponse;
use Illuminate\Support\Facades\Hash;

final class LoginCommandHandler
{
    public function __construct(private readonly UserRepositoryInterface $userRepository) {}

    public function __invoke(LoginCommand $command): LoginResponse|ErrorResponse
    {
        /** @var User|null $user */
        $user = $this->userRepository->findBy('email', $command->getEmail());

        if (! $user || Hash::check($command->getPassword(), $user->password) === false) {
            return ErrorResponse::create('Invalid credentials', 401);
        }

        $token = $user->createToken(
            name: 'auth_token',
            expiresAt: now()->addMinutes(30),
        )->plainTextToken;

        return LoginResponse::fromArray([
            'token' => $token,
        ]);
    }
}
