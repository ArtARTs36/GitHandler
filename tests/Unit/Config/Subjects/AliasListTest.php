<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Config\Subjects;

use ArtARTs36\GitHandler\Config\Subjects\Alias;
use ArtARTs36\GitHandler\Config\Subjects\AliasList;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class AliasListTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Config\Subjects\AliasList::getIterator
     * @covers \ArtARTs36\GitHandler\Config\Subjects\AliasList::__construct
     */
    public function testGetIterator(): void
    {
        $list = new AliasList($expected = [new Alias('1', '2')]);

        self::assertEquals($expected, $list->getIterator()->getArrayCopy());
    }
}
