<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Exceptions;

use ArtARTs36\GitHandler\Exceptions\TagAlreadyExists;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class TagAlreadyExistsTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Exceptions\TagAlreadyExists::__construct
     */
    public function testConstructor(): void
    {
        $e = new TagAlreadyExists('test');

        self::assertEquals('Tag "test" already exists!', $e->getMessage());
    }
}
