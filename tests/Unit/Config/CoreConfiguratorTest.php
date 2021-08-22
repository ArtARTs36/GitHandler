<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Config;

use ArtARTs36\GitHandler\Config\Configurators\CoreConfigurator;
use ArtARTs36\GitHandler\Config\Subjects\Core;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class CoreConfiguratorTest extends TestCase
{
    public function providerForTestParse(): array
    {
        return [
            [
                [],
                [
                    'autocrlf' => '',
                    'ignoreCase' => false,
                    'repositoryFormatVersion' => 0,
                    'bare' => false,
                    'logAllRefUpdates' => false,
                    'preComposeUnicode' => false,
                    'fileMode' => false,
                ],
            ],
            [
                [
                    'autocrlf' => 'auto',
                    'ignorecase' => 'true',
                    'repositoryformatversion' => 5,
                    'bare' => 'true',
                    'logallrefupdates' => 'true',
                    'precomposeunicode' => 'true',
                    'filemode' => 'true',
                ],
                [
                    'autocrlf' => 'auto',
                    'ignoreCase' => true,
                    'repositoryFormatVersion' => 5,
                    'bare' => true,
                    'logAllRefUpdates' => true,
                    'preComposeUnicode' => true,
                    'fileMode' => true,
                ],
            ]
        ];
    }

    /**
     * @dataProvider providerForTestParse
     * @covers \ArtARTs36\GitHandler\Config\Configurators\CoreConfigurator::parse
     */
    public function testParse(array $raw, array $expected): void
    {
        $configurator = new CoreConfigurator();

        //

        self::assertSame($expected, $configurator->parse($raw)->toArray());
    }
}
