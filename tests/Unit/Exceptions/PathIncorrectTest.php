<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Exceptions;

use ArtARTs36\GitHandler\Exceptions\PathIncorrect;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class PathIncorrectTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Exceptions\PathIncorrect::__construct()
     */
    public function testConstructor(): void
    {
        $exception = new PathIncorrect($path = '/non-exists-path/');

        self::assertEquals($path, $exception->incorrectPath);
        self::assertEquals("Path $path incorrect!", $exception->getMessage());
    }
}
