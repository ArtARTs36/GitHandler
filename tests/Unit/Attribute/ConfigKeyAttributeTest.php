<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Attribute;

use ArtARTs36\GitHandler\Attributes\ConfigKey;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class ConfigKeyAttributeTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Attributes\ConfigKey::__construct
     * @covers \ArtARTs36\GitHandler\Attributes\ConfigKey::__toString
     */
    public function testToString(): void
    {
        $key = new ConfigKey('remote');

        self::assertEquals('remote', $key->__toString());
    }
}
