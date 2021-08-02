<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Config;

use ArtARTs36\GitHandler\Config\Configurators\BranchConfigurator;
use ArtARTs36\GitHandler\Config\Subjects\BranchList;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class BranchConfiguratorTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Config\Configurators\BranchConfigurator::parse
     * @covers \ArtARTs36\GitHandler\Config\Configurators\BranchConfigurator::buildBranchName
     */
    public function testParse(): void
    {
        $raw = [
            'branch.master.remote' => 'origin',
            'branch.master.merge' => 'refs/heads/master',
            'branch.2.x.remote' => 'origin',
            'branch.2.x.merge' => 'refs/heads/2.x',
            'branch.readme.remote' => 'origin',
            'branch.readme.merge' => 'refs/heads/readme',
            'branch.update-shell-command.remote' => 'origin',
            'branch.update-shell-command.merge' => 'refs/heads/update-shell-command',
            'branch.remove-webmozart-assert.remote' => 'origin',
            'branch.remove-webmozart-assert.merge' => 'refs/heads/remove-webmozart-assert',
            'branch.branch-configurator.remote' => 'origin',
            'branch.branch-configurator.merge' => 'refs/heads/branch-configurator',
        ];

        $configurator = new BranchConfigurator();
        /** @var BranchList $result */
        $result = $configurator->parse($raw);

        self::assertInstanceOf(BranchList::class, $result);
        self::assertCount(6, $result->branches);
    }
}
