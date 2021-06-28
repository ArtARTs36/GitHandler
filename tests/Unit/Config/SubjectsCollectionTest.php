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

    /**
     * @covers \ArtARTs36\GitHandler\Config\Subjects\SubjectsCollection::toArray
     */
    public function testToArray(): void
    {
        $anonym2 = new class extends AbstractSubject {
            public $var2;

            public function __construct()
            {
                $this->var2 = 'value2';
            }

            public function name(): string
            {
                return 'anonym2';
            }
        };

        $collection = new SubjectsCollection([new class($anonym2) extends AbstractSubject {
            public $var;

            public function __construct(ConfigSubject $var)
            {
                $this->var = $var;
            }

            public function name(): string
            {
                return 'anonym1';
            }
        }]);

        self::assertSame([
            'anonym1' => [
                'var' => $anonym2,
            ],
        ], $collection->toArray());
    }
}
