<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Support\TypeCaster;

final class TypeCasterTest extends TestCase
{
    public function providerForTestBoolean(): array
    {
        return [
            ['true', true],
            ['false', false],
            ['random', false],
        ];
    }

    /**
     * @dataProvider providerForTestBoolean
     * @covers \ArtARTs36\GitHandler\Support\TypeCaster::boolean
     */
    public function testBoolean(string $raw, bool $expected): void
    {
        self::assertEquals($expected, TypeCaster::boolean($raw));
    }

    public function providerForTestInteger(): array
    {
        return [
            [
                [
                    'key1' => '2',
                ],
                'key1',
                2,
            ],
            [
                [
                    'key1' => '2',
                ],
                'key2',
                0,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestInteger
     * @covers \ArtARTs36\GitHandler\Support\TypeCaster::integer
     */
    public function testInteger(array $raw, string $key, int $expected): void
    {
        self::assertEquals($expected, TypeCaster::integer($raw, $key));
    }
}
