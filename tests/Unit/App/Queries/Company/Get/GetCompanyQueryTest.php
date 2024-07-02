<?php

declare(strict_types=1);

namespace Tests\Unit\App\Queries\Company\Get;

use App\Queries\Company\Get\GetCompanyQuery;
use Tests\UnitTestCase;

final class GetCompanyQueryTest extends UnitTestCase
{
    public function testGetters(): void
    {
        $query = GetCompanyQuery::fromArray([
            'id' => 'Company Id',
        ]);

        $this->assertEquals('Company Id', $query->getId());
    }
}
