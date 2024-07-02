<?php

declare(strict_types=1);

namespace Tests\Unit\App\Commands\Company\Update;

use App\Commands\Company\Update\UpdateCompanyCommand;
use Tests\UnitTestCase;

final class UpdateCompanyCommandTest extends UnitTestCase
{
    public function testGetters(): void
    {
        $command = UpdateCompanyCommand::fromArray([
            'id' => 'id',
            'name' => 'name',
            'description' => 'description',
            'company_owner_id' => 'companyOwnerId',
        ]);

        $this->assertSame('id', $command->getId());
        $this->assertSame('name', $command->getName());
        $this->assertSame('description', $command->getDescription());
        $this->assertSame('companyOwnerId', $command->getCompanyOwnerId());
    }
}
