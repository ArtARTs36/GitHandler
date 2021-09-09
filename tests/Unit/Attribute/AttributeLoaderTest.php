<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Attribute;

use ArtARTs36\GitHandler\Attributes\Loader\AttributeLoader;
use ArtARTs36\GitHandler\Attributes\Loader\NativeDriver;
use ArtARTs36\GitHandler\Attributes\Loader\TokenDriver;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class AttributeLoaderTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Attributes\Loader\AttributeLoader::make
     */
    public function testMakeOnPhp7(): void
    {
        $loader = AttributeLoader::make(70000);

        self::assertInstanceOf(TokenDriver::class, $this->getPropertyValueOfObject($loader, 'driver'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Attributes\Loader\AttributeLoader::make
     */
    public function testMakeOnPhp8(): void
    {
        $loader = AttributeLoader::make(80000);

        self::assertInstanceOf(NativeDriver::class, $this->getPropertyValueOfObject($loader, 'driver'));
    }
}
