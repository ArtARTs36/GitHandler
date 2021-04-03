<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Exceptions;

use ArtARTs36\GitHandler\Exceptions\RemoteAlreadyExists;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class RemoteAlreadyExistsTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Exceptions\RemoteAlreadyExists::__construct
     */
    public function testConstructor(): void
    {
        $e = new RemoteAlreadyExists('origin');

        self::assertEquals('Remote origin already exists', $e->getMessage());
        self::assertEquals('origin', $e->remoteName);
    }
}
