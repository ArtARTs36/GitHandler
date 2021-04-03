<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Exceptions;

use ArtARTs36\GitHandler\Exceptions\RemoteNotFound;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class RemoteNotFoundTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Exceptions\RemoteNotFound::__construct
     */
    public function testConstructor(): void
    {
        $e = new RemoteNotFound('origin');

        self::assertEquals('origin', $e->remoteName);
    }
}
