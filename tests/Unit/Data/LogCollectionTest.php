<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Data;

use ArtARTs36\GitHandler\Data\Author;
use ArtARTs36\GitHandler\Data\Log;
use ArtARTs36\GitHandler\Data\LogCollection;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class LogCollectionTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Data\LogCollection::__construct
     */
    public function testConstructorEmptyFail(): void
    {
        self::expectException(\InvalidArgumentException::class);

        new LogCollection([]);
    }

    /**
     * @covers \ArtARTs36\GitHandler\Data\LogCollection::__construct
     */
    public function testConstructorGenericTypeFail(): void
    {
        self::expectException(\InvalidArgumentException::class);

        new LogCollection([$this]);
    }

    /**
     * @covers \ArtARTs36\GitHandler\Data\LogCollection::__construct
     */
    public function testConstructorGood(): void
    {
        $collection = new LogCollection([
            new Log('', new \DateTime(), new Author('', ''), ''),
        ]);

        self::assertCount(1, $collection);
    }

    /**
     * @covers \ArtARTs36\GitHandler\Data\LogCollection::first
     * @covers \ArtARTs36\GitHandler\Data\LogCollection::last
     */
    public function testFirst(): void
    {
        $collection = new LogCollection([
            $log = new Log('', new \DateTime(), new Author('', ''), ''),
        ]);

        self::assertSame($log, $collection->first());
        self::assertSame($log, $collection->last());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Data\LogCollection::last
     */
    public function testLast(): void
    {
        $collection = new LogCollection([
            new Log('', new \DateTime(), new Author('', ''), ''),
            $twoLog = new Log('', new \DateTime(), new Author('', ''), ''),
        ]);

        self::assertSame($twoLog, $collection->last());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Data\LogCollection::filterByAuthorName
     */
    public function testFilterByAuthorName(): void
    {
        $expected = [
            new Log('', new \DateTime(), new Author('artem', '@'), 'a'),
            new Log('', new \DateTime(), new Author('artem', '@'), 'a'),
        ];

        $collection = new LogCollection(array_merge($expected, [
            new Log('', new \DateTime(), new Author('other', '@'), 'a'),
        ]));

        self::assertEquals($expected, $collection->filterByAuthorName('artem')->all());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Data\LogCollection::all
     */
    public function testAll(): void
    {
        $collection = new LogCollection($expected = [
            new Log('', new \DateTime(), new Author('artem', '@'), 'a'),
        ]);

        self::assertEquals($expected, $collection->all());
    }
}
