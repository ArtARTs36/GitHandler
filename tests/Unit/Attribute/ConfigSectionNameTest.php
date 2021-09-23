<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Attribute;

use ArtARTs36\GitHandler\Attributes\ConfigSectionName;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class ConfigSectionNameTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Attributes\ConfigSectionName::__toString
     */
    public function testToString(): void
    {
        $name = new ConfigSectionName();

        self::assertEquals(ConfigSectionName::class, $name->__toString());
    }
}
