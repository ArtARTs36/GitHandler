<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Exceptions;

use ArtARTs36\GitHandler\Exceptions\SubmoduleNotFound;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class SubmoduleNotFoundTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Exceptions\SubmoduleNotFound::__construct
     */
    public function testConstruct(): void
    {
        $exception = new SubmoduleNotFound('str');

        self::assertEquals('Module str not found!', $exception->getMessage());
    }
}
