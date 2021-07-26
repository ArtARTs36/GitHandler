<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Exceptions;

use ArtARTs36\GitHandler\Exceptions\ObjectNameNotValid;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class ObjectNameNotValidTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Exceptions\ObjectNameNotValid::__construct
     */
    public function testConstructor(): void
    {
        $exception = new ObjectNameNotValid('master');

        self::assertEquals('master', $exception->errorObjectName);
    }
}
