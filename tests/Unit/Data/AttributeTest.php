<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Data;

use ArtARTs36\GitHandler\Data\Attribute;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class AttributeTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Data\Attribute::pattern
     */
    public function testPattern(): void
    {
        $attribute = new Attribute('pattern', []);

        self::assertEquals('pattern', $attribute->pattern());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Data\Attribute::all
     */
    public function testAll(): void
    {
        $attribute = new Attribute('pattern', ['attr']);

        self::assertEquals(['attr'], $attribute->all());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Data\Attribute::has
     */
    public function testHas(): void
    {
        $attribute = new Attribute('pattern', ['attr', '123']);

        self::assertTrue($attribute->has('attr'));
    }
}
