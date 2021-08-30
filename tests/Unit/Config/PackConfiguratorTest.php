<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Config;

use ArtARTs36\GitHandler\Config\Configurators\PackConfigurator;
use ArtARTs36\GitHandler\Config\Subjects\Pack;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class PackConfiguratorTest extends TestCase
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
            ],
            [
                [
                    'windowmemory' => '1024GB',
                ],
                [
                    'windowMemory' => '1024GB',
                    'packSizeLimit' => '',
                    'threads' => 0,
                    'deltaCacheSize' => '',
                    'sizeLimit' => '',
                    'window' => 0,
                ],
            ],
            [
                [
                    'packsizelimit' => '1024GB',
                ],
                [
                    'windowMemory' => '',
                    'packSizeLimit' => '1024GB',
                    'threads' => 0,
                    'deltaCacheSize' => '',
                    'sizeLimit' => '',
                    'window' => 0,
                ],
            ],
            [
                [
                    'threads' => '1024',
                ],
                [
                    'windowMemory' => '',
                    'packSizeLimit' => '',
                    'threads' => 1024,
                    'deltaCacheSize' => '',
                    'sizeLimit' => '',
                    'window' => 0,
                ],
            ],
            [
                [
                    'deltacachesize' => '1024GB',
                ],
                [
                    'windowMemory' => '',
                    'packSizeLimit' => '',
                    'threads' => 0,
                    'deltaCacheSize' => '1024GB',
                    'sizeLimit' => '',
                    'window' => 0,
                ],
            ],
            [
                [
                    'sizelimit' => '1024GB',
                ],
                [
                    'windowMemory' => '',
                    'packSizeLimit' => '',
                    'threads' => 0,
                    'deltaCacheSize' => '',
                    'sizeLimit' => '1024GB',
                    'window' => 0,
                ],
            ],
            [
                [
                    'window' => 5,
                ],
                [
                    'windowMemory' => '',
                    'packSizeLimit' => '',
                    'threads' => 0,
                    'deltaCacheSize' => '',
                    'sizeLimit' => '',
                    'window' => 5,
                ],
            ],
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
