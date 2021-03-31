<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Support\TypeCaster;

class TypeCasterTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Support\TypeCaster::boolean
     */
    public function testBoolean(): void
    {
        self::assertTrue(TypeCaster::boolean('true'));
        self::assertFalse(TypeCaster::boolean('false'));
        self::assertFalse(TypeCaster::boolean('random'));
    }
}
