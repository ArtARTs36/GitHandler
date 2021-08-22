<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Data;

use ArtARTs36\GitHandler\Data\Remotes;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class RemotesTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Data\Remotes::createEmpty
     * @covers \ArtARTs36\GitHandler\Data\Remotes::__construct
     */
    public function testCreateEmpty(): void
    {
        $remotes = Remotes::createEmpty();

        self::assertTrue($remotes->push->equals(''));
        self::assertTrue($remotes->fetch->equals(''));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Data\Remotes::isEmpty
     * @covers \ArtARTs36\GitHandler\Data\Remotes::__construct
     */
    public function testIsEmpty(): void
    {
        self::assertTrue(Remotes::createEmpty()->isEmpty());
    }
}
