<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Config;

use ArtARTs36\GitHandler\Config\Configurators\SubmoduleConfigurator;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class SubmoduleConfiguratorTest extends TestCase
{
    public function providerForTestParse(): array
    {
        return [
            [
                [
                    'str.url' => 'site.ru',
                    'str.active' => 'false',
                ],
                'str',
                [
                    'url' => 'site.ru',
                    'active' => false,
                    'name' => 'str',
                ],
            ],
        ];
    }

    /**
     * @dataProvider providerForTestParse
     * @covers \ArtARTs36\GitHandler\Config\Configurators\SubmoduleConfigurator::parse
     * @covers \ArtARTs36\GitHandler\Config\Subjects\ConfigSubmodule::__construct
     */
    public function testParse(array $raw, string $key, array $expected): void
    {
        $configurator = $this->makeSubmoduleConfigurator();

        $result = $configurator->parse($raw);

        self::assertEquals($expected, $result->get($key)->toArray());
    }

    private function makeSubmoduleConfigurator(): SubmoduleConfigurator
    {
        return new SubmoduleConfigurator();
    }
}
