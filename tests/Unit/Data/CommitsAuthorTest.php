<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Data;

use ArtARTs36\GitHandler\Data\Author;
use ArtARTs36\GitHandler\Data\Commit;
use ArtARTs36\GitHandler\Data\CommitsAuthor;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class CommitsAuthorTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Data\CommitsAuthor::fromArray
     * @covers \ArtARTs36\GitHandler\Data\CommitsAuthor::__construct
     * @covers \ArtARTs36\GitHandler\Data\CommitsAuthor::toArray
     */
    public function testFromArray(): void
    {
        $expected = ['author' => new Author('', ''), 'commits' => []];

        $author = CommitsAuthor::fromArray($expected);

        self::assertEquals($expected, $author->toArray());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Data\CommitsAuthor::getIterator
     */
    public function testGetIterator(): void
    {
        $author = new CommitsAuthor(new Author('', ''), $expected = [
            new Commit(sha1('123')),
        ]);

        self::assertEquals($expected, (array) $author->getIterator());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Data\CommitsAuthor::count
     */
    public function testCount(): void
    {
        $author = new CommitsAuthor(new Author('', ''), [new Commit('123')]);

        self::assertCount(1, $author);
    }
}
