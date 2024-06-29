<?php

declare(strict_types=1);

namespace Domains\User\Http\Controllers;

use App\Commands\Auth\Login\LoginCommand;
use App\Http\Controllers\Controller;
use App\Queries\User\Me\GetUserQuery;
use Domains\User\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function login(LoginRequest $request): ?JsonResponse
    {
        return $this->dispatch($request, LoginCommand::class);
    }

    public function get(): JsonResponse
    {
        return $this->ask(GetUserQuery::class);
    }
}
