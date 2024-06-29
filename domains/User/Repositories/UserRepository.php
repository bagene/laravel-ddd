<?php

declare(strict_types=1);

namespace Domains\User\Repositories;

use App\Shared\AbstractRepository;
use Domains\User\Contracts\UserRepositoryInterface;
use Domains\User\Models\User;
use Illuminate\Database\DatabaseManager;

final class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    public function __construct(DatabaseManager $database, User $model)
    {
        parent::__construct($database, $model);
    }
}
