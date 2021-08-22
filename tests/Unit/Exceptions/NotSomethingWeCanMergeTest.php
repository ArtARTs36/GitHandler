<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Exceptions;

use ArtARTs36\GitHandler\Exceptions\NotSomethingWeCanMerge;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class NotSomethingWeCanMergeTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Exceptions\NotSomethingWeCanMerge::__construct
     */
    public function testConstructor(): void
    {
        $exception = new NotSomethingWeCanMerge('branch1');

        self::assertEquals('branch1', $exception->failedMergeBranch);
    }
}
