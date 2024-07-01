<?php

declare(strict_types=1);

namespace Tests\Unit\Domains\Company\DTO;

use Domains\Company\DTO\CompanyPayload;
use Tests\UnitTestCase;

final class CompanyPayloadTest extends UnitTestCase
{
    public function testGetters(): void
    {
        $payload = CompanyPayload::fromArray([
            'name' => 'Company Name',
            'description' => 'Company Description',
            'companyOwnerId' => 'company-owner-id',
        ]);

        $this->assertSame('Company Name', $payload->getName());
        $this->assertSame('Company Description', $payload->getDescription());
        $this->assertSame('company-owner-id', $payload->getCompanyOwnerId());
    }
}
