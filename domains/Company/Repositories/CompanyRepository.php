<?php

declare(strict_types=1);

namespace Domains\Company\Repositories;

use App\Shared\AbstractRepository;
use Domains\Company\Contracts\CompanyRepositoryInterface;
use Domains\Company\Models\Company;
use Illuminate\Database\DatabaseManager;

final class CompanyRepository extends AbstractRepository implements CompanyRepositoryInterface
{
    public function __construct(DatabaseManager $database, Company $model)
    {
        parent::__construct($database, $model);
    }
}
