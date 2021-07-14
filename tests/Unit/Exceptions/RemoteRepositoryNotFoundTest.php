<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Exceptions;

use ArtARTs36\GitHandler\Exceptions\RemoteRepositoryNotFound;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class RemoteRepositoryNotFoundTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Exceptions\RemoteRepositoryNotFound::__construct
     */
    public function testConstructor(): void
    {
        $exception = new RemoteRepositoryNotFound('https://site.ru');

        self::assertEquals('https://site.ru', $exception->errorRemoteRepository);
    }
}
