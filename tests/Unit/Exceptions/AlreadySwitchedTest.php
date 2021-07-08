<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Exceptions;

use ArtARTs36\GitHandler\Exceptions\AlreadySwitched;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class AlreadySwitchedTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Exceptions\AlreadySwitched::__construct
     */
    public function testConstructor(): void
    {
        $exception = new AlreadySwitched('master');

        self::assertEquals('master', $exception->errorBranch);
    }
}
