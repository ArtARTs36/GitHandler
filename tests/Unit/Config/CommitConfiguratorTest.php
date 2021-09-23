<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Config;

use ArtARTs36\GitHandler\Config\Configurators\CommitConfigurator;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class CommitConfiguratorTest extends TestCase
{
    public function providerForTestParse(): array
    {
        return [
            [
                [''],
                ['templatePath' => ''],
            ],
        ];
    }

    /**
     * @dataProvider providerForTestParse
     * @covers \ArtARTs36\GitHandler\Config\Configurators\CommitConfigurator::parse
     * @covers \ArtARTs36\GitHandler\Config\Subjects\ConfigCommit::__construct
     */
    public function testParse(array $raw, array $commit): void
    {
        $configurator = new CommitConfigurator();

        self::assertEquals($configurator->parse($raw)->toArray(), $commit);
    }
}
