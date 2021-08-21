<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Data;

use ArtARTs36\GitHandler\Data\Commit;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class CommitTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Data\Commit::__toString
     */
    public function testToString(): void
    {
        $commit = new Commit($hash = sha1(1));

        self::assertEquals($hash, $commit);
    }

    /**
     * @covers \ArtARTs36\GitHandler\Data\Commit::getAbbreviatedHash
     */
    public function testGetAbbreviatedHash(): void
    {
        $commit = new Commit('7bfab23737fad677905ae7ddd3ac76e2e31f30a4');

        self::assertEquals('7bfab2', $commit->getAbbreviatedHash());
    }
}
