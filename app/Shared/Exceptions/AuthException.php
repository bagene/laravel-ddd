<?php

declare(strict_types=1);

namespace App\Shared\Exceptions;

final class AuthException extends \Exception
{
    public function __construct(string $message = 'Unauthorized', int $code = 401)
    {
        parent::__construct($message, $code);
    }
}
