<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Data;

use ArtARTs36\GitHandler\Config\Subjects\ConfigSubmodule;
use ArtARTs36\GitHandler\Config\Subjects\ConfigSubmoduleList;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class ConfigSubmoduleListTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Config\Subjects\ConfigSubmoduleList::get
     * @covers \ArtARTs36\GitHandler\Config\Subjects\ConfigSubmoduleList::__construct
     */
    public function testGetOnNotFound(): void
    {
        $list = new ConfigSubmoduleList([]);

        self::assertNull($list->get('rand'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Config\Subjects\ConfigSubmoduleList::get
     * @covers \ArtARTs36\GitHandler\Config\Subjects\ConfigSubmoduleList::__construct
     * @covers \ArtARTs36\GitHandler\Config\Subjects\ConfigSubmodule::__construct
     */
    public function testGetOnFound(): void
    {
        $list = new ConfigSubmoduleList([]);

        self::assertNull($list->get('rand'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Config\Subjects\ConfigSubmoduleList::getIterator
     */
    public function testGetIterator(): void
    {
        $list = new ConfigSubmoduleList($arr = ['str' => new ConfigSubmodule('', '', true)]);

        self::assertEquals($arr, $list->getIterator()->getArrayCopy());
    }
}
