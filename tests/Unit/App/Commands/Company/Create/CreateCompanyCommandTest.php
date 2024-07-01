<?php

declare(strict_types=1);

namespace Tests\Unit\App\Commands\Company\Create;

use App\Commands\Company\Create\CreateCompanyCommand;
use Tests\UnitTestCase;

final class CreateCompanyCommandTest extends UnitTestCase
{
    public function testGetters(): void
    {
        $command = CreateCompanyCommand::fromArray([
            'name' => 'Company Name',
            'description' => 'Company Description',
            'companyOwnerId' => 'company-owner-id',
        ]);

        $this->assertSame('Company Name', $command->getName());
        $this->assertSame('Company Description', $command->getDescription());
        $this->assertSame('company-owner-id', $command->getCompanyOwnerId());
    }

    public function testGettersWithoutCompanyOwnerId(): void
    {
        $command = CreateCompanyCommand::fromArray([
            'name' => 'Company Name',
            'description' => 'Company Description',
        ]);

        $this->assertSame('Company Name', $command->getName());
        $this->assertSame('Company Description', $command->getDescription());
        $this->assertNull($command->getCompanyOwnerId());
    }
}
