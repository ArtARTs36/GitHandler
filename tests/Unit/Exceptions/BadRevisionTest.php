<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Exceptions;

use ArtARTs36\GitHandler\Exceptions\BadRevision;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class BadRevisionTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Exceptions\BadRevision::__construct
     */
    public function testConstructor(): void
    {
        $sha = sha1('test');

        self::assertEquals($sha, (new BadRevision($sha))->failedRevision);
    }
}
