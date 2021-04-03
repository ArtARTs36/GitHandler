<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Config;

use ArtARTs36\GitHandler\Config\Subjects\AbstractSubject;
use ArtARTs36\GitHandler\Config\Subjects\SubjectsCollection;
use ArtARTs36\GitHandler\Contracts\ConfigSubject;
use ArtARTs36\GitHandler\Support\ToArray;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class SubjectsCollectionTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Config\Subjects\SubjectsCollection::count
     * @covers \ArtARTs36\GitHandler\Config\Subjects\SubjectsCollection::getIterator
     * @covers \ArtARTs36\GitHandler\Config\Subjects\SubjectsCollection::all
     */
    public function testCount(): void
    {
        $collection = new SubjectsCollection($array = [new class extends AbstractSubject {
        }]);

        self::assertEquals(1, $collection->count());
        self::assertCount(1, $collection);

        self::assertEquals($array, $collection->all());
        self::assertEquals($array, $collection->getIterator()->getArrayCopy());
    }
}
