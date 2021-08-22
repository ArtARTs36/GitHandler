<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Exceptions;

use ArtARTs36\GitHandler\Exceptions\CannotMergeAbort;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class CannotMergeAbortTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Exceptions\CannotMergeAbort::__construct
     */
    public function testMessage(): void
    {
        $exception = new CannotMergeAbort('reason #1');

        self::assertEquals('fatal: There is no merge to abort (reason #1)', $exception->getMessage());
    }
}
