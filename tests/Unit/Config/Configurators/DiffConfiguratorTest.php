<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Config\Configurators;

use ArtARTs36\GitHandler\Config\Configurators\DiffConfigurator;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class DiffConfiguratorTest extends TestCase
{
    public function providerForTestParse(): array
    {
        return [
            [
                [
                    'external' => 'external_path',
                    'renames' => 'true',
                ],
                [
                    'externalPath' => 'external_path',
                    'renames' => true,
                ],
            ],
        ];
    }

    /**
     * @dataProvider providerForTestParse
     * @covers \ArtARTs36\GitHandler\Config\Configurators\DiffConfigurator::parse
     * @covers \ArtARTs36\GitHandler\Config\Subjects\ConfigDiff::__construct
     */
    public function testParse(array $raw, array $expected): void
    {
        $configurator = new DiffConfigurator();

        self::assertEquals($expected, $configurator->parse($raw)->toArray());
    }
}
