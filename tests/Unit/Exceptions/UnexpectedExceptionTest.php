<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Exceptions;

use ArtARTs36\GitHandler\Exceptions\UnexpectedException;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class UnexpectedExceptionTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Exceptions\UnexpectedException::__construct
     */
    public function testConstructor(): void
    {
        $exception = new UnexpectedException('git clone');

        self::assertEquals('git clone', $exception->errorCommand);
        self::assertEquals('Unexpected exception after execution command: git clone', $exception->getMessage());
    }
}
