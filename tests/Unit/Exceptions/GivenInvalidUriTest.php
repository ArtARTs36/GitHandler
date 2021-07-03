<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Exceptions;

use ArtARTs36\GitHandler\Exceptions\GivenInvalidUri;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class GivenInvalidUriTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Exceptions\GivenInvalidUri::__construct
     */
    public function testConstructor(): void
    {
        $exception = new GivenInvalidUri($uri = 'https://site.ru');

        self::assertEquals($uri, $exception->failedUrl);
    }
}
