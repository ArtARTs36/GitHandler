<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Data;

use ArtARTs36\GitHandler\Data\Author;
use ArtARTs36\GitHandler\Data\Commit;
use ArtARTs36\GitHandler\Data\Log;
use ArtARTs36\GitHandler\Data\LogCollection;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class LogCollectionTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Data\LogCollection::count
     * @covers \ArtARTs36\GitHandler\Data\LogCollection::__construct
     */
    public function testCount(): void
    {
        $collection = new LogCollection([
            new Log(new Commit(''), new \DateTime(), new Author('', ''), ''),
        ]);

        self::assertCount(1, $collection);
    }

    /**
     * @covers \ArtARTs36\GitHandler\Data\LogCollection::first
     * @covers \ArtARTs36\GitHandler\Data\LogCollection::__construct
     */
    public function testFirst(): void
    {
        $collection = new LogCollection([
            $log = new Log(new Commit(''), new \DateTime(), new Author('', ''), ''),
            new Log(new Commit(''), new \DateTime(), new Author('', ''), ''),
        ]);

        self::assertSame($log, $collection->first());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Data\LogCollection::last
     * @covers \ArtARTs36\GitHandler\Data\LogCollection::__construct
     */
    public function testLast(): void
    {
        $collection = new LogCollection([
            new Log(new Commit(''), new \DateTime(), new Author('', ''), ''),
            $twoLog = new Log(new Commit(''), new \DateTime(), new Author('', ''), ''),
        ]);

        self::assertSame($twoLog, $collection->last());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Data\LogCollection::filterByAuthorName
     * @covers \ArtARTs36\GitHandler\Data\LogCollection::__construct
     */
    public function testFilterByAuthorName(): void
    {
        $expected = [
            new Log(new Commit(''), new \DateTime(), new Author('artem', '@'), 'a'),
            new Log(new Commit(''), new \DateTime(), new Author('artem', '@'), 'a'),
        ];

        $collection = new LogCollection(array_merge($expected, [
            new Log(new Commit(''), new \DateTime(), new Author('other', '@'), 'a'),
        ]));

        self::assertEquals($expected, $collection->filterByAuthorName('artem')->all());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Data\LogCollection::all
     * @covers \ArtARTs36\GitHandler\Data\LogCollection::__construct
     */
    public function testAll(): void
    {
        $collection = new LogCollection($expected = [
            new Log(new Commit(''), new \DateTime(), new Author('artem', '@'), 'a'),
        ]);

        self::assertEquals($expected, $collection->all());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Data\LogCollection::filter
     * @covers \ArtARTs36\GitHandler\Data\LogCollection::__construct
     */
    public function testFilterWithReturnNull(): void
    {
        $collection = new LogCollection([
            new Log(new Commit(''), new \DateTime(), new Author('artem', '@'), 'a'),
            new Log(new Commit(''), new \DateTime(), new Author('artem', '@'), 'b'),
        ]);

        //

        self::assertNull($collection->filter(function () {
            return false;
        }));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Data\LogCollection::filter
     * @covers \ArtARTs36\GitHandler\Data\LogCollection::__construct
     */
    public function testFilter(): void
    {
        $collection = new LogCollection([
            new Log(new Commit(''), new \DateTime(), new Author('artem', '@'), 'a'),
            $lastLog = new Log(new Commit(''), new \DateTime(), new Author('artem', '@'), 'b'),
        ]);

        //

        $filteredCollection = $collection->filter(function (Log $log) {
            return $log->message === 'b';
        });

        self::assertSame([$lastLog], $filteredCollection->all());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Data\LogCollection::getIterator
     * @covers \ArtARTs36\GitHandler\Data\LogCollection::__construct
     */
    public function testGetIterator(): void
    {
        $collection = new LogCollection($expected = [
            new Log(new Commit(''), new \DateTime(), new Author('artem', '@'), 'a'),
            new Log(new Commit(''), new \DateTime(), new Author('artem', '@'), 'b'),
        ]);

        self::assertSame($expected, $collection->getIterator()->getArrayCopy());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Data\LogCollection::filterByDate
     * @covers \ArtARTs36\GitHandler\Data\LogCollection::__construct
     */
    public function testFilterByDate(): void
    {
        $expected = [
            new Log(new Commit(''), new \DateTime(), new Author('artem', '@'), 'a'),
            new Log(new Commit(''), new \DateTime(), new Author('artem', '@'), 'a'),
        ];

        $collection = new LogCollection(array_merge($expected, [
            new Log(new Commit(''), new \DateTime('7 day ago'), new Author('other', '@'), 'a'),
        ]));

        self::assertEquals($expected, $collection->filterByDate(new \DateTime())->all());
    }
}
