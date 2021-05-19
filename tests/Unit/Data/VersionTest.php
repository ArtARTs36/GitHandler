<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Data;

use ArtARTs36\GitHandler\Data\Version;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class VersionTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Data\Version::__toString()
     */
    public function testToString(): void
    {
        $version = new Version('full', '1', '2', '3');

        self::assertEquals('full', $version->__toString());
    }
}
