<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Config;

use ArtARTs36\GitHandler\Config\Configurators\AliasConfigurator;
use ArtARTs36\GitHandler\Config\Subjects\Alias;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class AliasConfiguratorTest extends TestCase
{
    public function providerForTestParse(): array
    {
        return [
            [
                [
                    'lg' => 'log',
                    'ch' => 'checkout',
                ],
                [
                    'aliases' => [
                        'lg' => [
                            'name' => 'lg',
                            'script' => 'log',
                        ],
                        'ch' => [
                            'name' => 'ch',
                            'script' => 'checkout',
                        ],
                    ],
                ]
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\GitHandler\Config\Configurators\AliasConfigurator::parse
     * @covers \ArtARTs36\GitHandler\Config\Subjects\Alias::__construct
     * @dataProvider providerForTestParse
     */
    public function testParse(array $raw, array $expected): void
    {
        self::assertEquals($expected, array_map(function (array $item) {
            return array_map(function (Alias $alias) {
                return $alias->toArray();
            }, $item);
        }, (new AliasConfigurator())->parse($raw)->toArray()));
    }
}
