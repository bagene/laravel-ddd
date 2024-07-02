<?php

declare(strict_types=1);

namespace Tests\Unit\App\Queries\Company\GetAll;

use App\Queries\Company\GetAll\GetAllCompanyQuery;
use Tests\UnitTestCase;

final class GetAllCompanyQueryTest extends UnitTestCase
{
    public function testGetters(): void
    {
        $query = GetAllCompanyQuery::fromArray([
            'name' => 'Company Name',
            'description' => 'Company Description',
            'company_owner_id' => 'Company Owner Id',
            'pagination' => ['page' => 1, 'limit' => 10],
        ]);

        $this->assertEquals('Company Name', $query->getName());
        $this->assertEquals('Company Description', $query->getDescription());
        $this->assertEquals('Company Owner Id', $query->getCompanyOwnerId());
        $this->assertEquals(['page' => 1, 'limit' => 10], $query->getPagination());
    }

    public function testGettersNull(): void
    {
        $query = GetAllCompanyQuery::fromArray([]);

        $this->assertNull($query->getName());
        $this->assertNull($query->getDescription());
        $this->assertNull($query->getCompanyOwnerId());
        $this->assertNull($query->getPagination());
    }
}
