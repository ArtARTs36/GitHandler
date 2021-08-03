<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Data;

use ArtARTs36\GitHandler\Data\Commit;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class CommitTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Data\Commit::__toString
     */
    public function testToString(): void
    {
        $commit = new Commit($hash = sha1(1));

        self::assertEquals($hash, $commit);
    }
}
