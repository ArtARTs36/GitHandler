<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Data;

use ArtARTs36\GitHandler\Data\Remotes;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class RemotesTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Data\Remotes::createEmpty
     */
    public function testCreateEmpty(): void
    {
        $remotes = Remotes::createEmpty();

        self::assertEquals('', $remotes->push);
        self::assertEquals('', $remotes->fetch);
    }
}
