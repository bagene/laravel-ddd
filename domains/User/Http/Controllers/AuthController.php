<?php

declare(strict_types=1);

namespace Domains\User\Http\Controllers;

use App\Commands\Auth\Login\LoginCommand;
use App\Http\Controllers\Controller;
use App\Queries\User\Me\GetUserQuery;
use Domains\User\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Response;
use Knuckles\Scribe\Attributes\ResponseFromFile;

#[Group(name: 'Auth', description: 'Authentication')]
class AuthController extends Controller
{
    #[Response(content: [
        'data' => [
            'token' => 'string',
        ],
    ], status: 200)]
    #[ResponseFromFile(
        file: 'infrastructure/Schema/Auth/Login/invalid-credentials.json',
        status: 401,
    )]
    #[ResponseFromFile(
        file: 'infrastructure/Schema/Auth/Login/invalid-login-payload.json',
        status: 422,
    )]
    public function login(LoginRequest $request): JsonResponse
    {
        return $this->dispatch($request, LoginCommand::class);
    }

    #[Authenticated]
    #[ResponseFromFile(
        file: 'infrastructure/Schema/Auth/user.json',
        status: 200,
    )]
    public function get(): JsonResponse
    {
        return $this->ask(GetUserQuery::class);
    }
}
