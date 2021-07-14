<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Exceptions;

use ArtARTs36\GitHandler\Exceptions\ReferenceInvalid;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class ReferenceInvalidTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Exceptions\ReferenceInvalid::__construct
     */
    public function testConstructor(): void
    {
        $exception = new ReferenceInvalid('master');

        self::assertEquals('master', $exception->errorReference);
    }
}
