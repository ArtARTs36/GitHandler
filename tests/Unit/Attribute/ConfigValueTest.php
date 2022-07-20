<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Attribute;

use ArtARTs36\GitHandler\Attributes\ConfigValue;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class ConfigValueTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Attributes\ConfigValue::__toString
     */
    public function testToString(): void
    {
        $value = new ConfigValue();

        self::assertEquals(ConfigValue::class, $value->__toString());
    }
}
