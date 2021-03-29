<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Data;

use ArtARTs36\GitHandler\Data\Author;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class AuthorTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Data\Author::equals
     */
    public function testEquals(): void
    {
        $author = new Author('test', 'test@mail.ru');

        //

        self::assertTrue($author->equals($author));
        self::assertTrue($author->equals(new Author('test', 'test@mail.ru')));

        //

        self::assertFalse($author->equals(new Author('test', '')));
        self::assertFalse($author->equals(new Author('', 'test@mail.ru')));
    }
}
