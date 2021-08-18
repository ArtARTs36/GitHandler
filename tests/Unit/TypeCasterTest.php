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
}
