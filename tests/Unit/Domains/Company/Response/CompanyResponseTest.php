<?php

declare(strict_types=1);

namespace Tests\Unit\Domains\Company\Response;

use Domains\Company\Response\CompanyResponse;
use Tests\UnitTestCase;

final class CompanyResponseTest extends UnitTestCase
{
    public function testGetters(): void
    {
        $response = CompanyResponse::fromArray([
            'id' => 'company-id',
            'name' => 'Company Name',
            'description' => 'Company Description',
            'company_owner' => [
                'id' => 'company-owner-id',
                'name' => 'Company Owner Name',
                'email' => 'test@example.org',
                'email_verified_at' => '2021-01-01 00:00:00',
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ],
            'created_at' => '2021-01-01 00:00:00',
            'updated_at' => '2021-01-01 00:00:00',
        ]);

        $this->assertSame('company-id', $response->getId());
        $this->assertSame('Company Name', $response->getName());
        $this->assertSame('Company Description', $response->getDescription());
        $this->assertSame('company-owner-id', $response->getCompanyOwner()['id']);
        $this->assertSame('Company Owner Name', $response->getCompanyOwner()['name']);
        $this->assertSame('test@example.org', $response->getCompanyOwner()['email']);
        $this->assertSame('2021-01-01 00:00:00', $response->getCompanyOwner()['email_verified_at']);
        $this->assertSame('2021-01-01 00:00:00', $response->getCompanyOwner()['created_at']);
        $this->assertSame('2021-01-01 00:00:00', $response->getCompanyOwner()['updated_at']);
        $this->assertSame('2021-01-01 00:00:00', $response->getCreatedAt());
        $this->assertSame('2021-01-01 00:00:00', $response->getUpdatedAt());
    }
}
