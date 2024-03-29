<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Data;

use ArtARTs36\GitHandler\Data\Version;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;

final class VersionTest extends GitTestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Data\Version::__toString
     * @covers \ArtARTs36\GitHandler\Data\Version::__construct
     */
    public function testToString(): void
    {
        $version = new Version($expected = 'full', 1, 0, 0);

        self::assertEquals($expected, $version->__toString());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Data\Version::toTag
     * @covers \ArtARTs36\GitHandler\Data\Version::__construct
     */
    public function testToTag(): void
    {
        $version = new Version('full', 1, 2, 3);

        self::assertEquals('1.2.3', $version->toTag());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Data\Version::compare
     * @covers \ArtARTs36\GitHandler\Data\Version::__construct
     */
    public function testCompareOnObject(): void
    {
        $one = new Version('full', 1, 2, 3);
        $two = new Version('full', 1, 2, 4);

        self::assertEquals(-1, $one->compare($two));
    }
}
