<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Exceptions;

use ArtARTs36\GitHandler\Exceptions\StashDoesNotExists;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class StashDoesNotExistsTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Exceptions\StashDoesNotExists::__construct
     */
    public function testConstructor(): void
    {
        $exception = new StashDoesNotExists(2);

        self::assertSame(2, $exception->errorStashId);
    }
}
