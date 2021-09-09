<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Data;

use ArtARTs36\GitHandler\Data\Submodule;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class SubmoduleTest extends TestCase
{
    public function providerForTestToEquals(): array
    {
        return [
            [
                [
                    'name' => 'str',
                    'path' => 'str',
                    'url' => 'site.ru',
                ],
                [
                    'name' => 'artem',
                    'path' => 'artem',
                    'url' => 'site.ru',
                ],
                false,
            ],
            [
                [
                    'name' => 'str',
                    'path' => 'str',
                    'url' => 'site.ru',
                ],
                [
                    'name' => 'str',
                    'path' => 'artem',
                    'url' => 'site.ru',
                ],
                true,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestToEquals
     * @covers \ArtARTs36\GitHandler\Data\Submodule::equals
     * @covers \ArtARTs36\GitHandler\Data\Submodule::fromArray
     * @covers \ArtARTs36\GitHandler\Data\Submodule::__construct
     */
    public function testToEquals(array $one, array $two, bool $expected): void
    {
        self::assertEquals($expected, Submodule::fromArray($one)->equals(Submodule::fromArray($two)));
    }
}
