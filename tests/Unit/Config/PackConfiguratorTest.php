<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Config;

use ArtARTs36\GitHandler\Config\Configurators\PackConfigurator;
use ArtARTs36\GitHandler\Config\Subjects\Pack;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class PackConfiguratorTest extends TestCase
{
    public function providerForTestParse(): array
    {
        return [
            [
                [],
                [
                    'windowMemory' => '',
                    'packSizeLimit' => '',
                    'threads' => 0,
                    'deltaCacheSize' => '',
                    'sizeLimit' => '',
                    'window' => 0,
                ]
            ]
        ];
    }

    /**
     * @dataProvider providerForTestParse
     * @covers \ArtARTs36\GitHandler\Config\Configurators\PackConfigurator::parse
     */
    public function testParse(array $raw, array $expected): void
    {
        $configurator = new PackConfigurator();

        self::assertEquals($expected, $configurator->parse($raw)->toArray());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Config\Configurators\PackConfigurator::parse
     */
    public function testParseInstanceof(): void
    {
        self::assertInstanceOf(Pack::class, (new PackConfigurator())->parse([]));
    }
}
