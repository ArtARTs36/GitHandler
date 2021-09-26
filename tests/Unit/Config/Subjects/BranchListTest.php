<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Config\Subjects;

use ArtARTs36\GitHandler\Config\Subjects\Branch;
use ArtARTs36\GitHandler\Config\Subjects\BranchList;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class BranchListTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Config\Subjects\BranchList::get
     */
    public function testGet(): void
    {
        $list = new BranchList([
            'test' => $branch = Branch::fromLinks('test', []),
        ]);

        self::assertSame($branch, $list->get('test'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Config\Subjects\BranchList::getIterator
     */
    public function testGetIterator(): void
    {
        $list = new BranchList($expected = [
            'test' => Branch::fromLinks('test', []),
        ]);

        self::assertEquals($expected, $list->getIterator()->getArrayCopy());
    }
}
