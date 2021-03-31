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

        self::assertTrue($remotes->push->equals(''));
        self::assertTrue($remotes->fetch->equals(''));
    }
}
