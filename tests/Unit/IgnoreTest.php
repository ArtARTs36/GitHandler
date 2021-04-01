<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\GitSimpleFactory;
use ArtARTs36\GitHandler\Repository;
use ArtARTs36\GitHandler\Tests\Support\ArrayFileSystem;

class IgnoreTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Ignore::add
     * @covers \ArtARTs36\GitHandler\Ignore::has
     */
    public function testAdd(): void
    {
        $git = GitSimpleFactory::factory(__DIR__);
        $fileSystem = new ArrayFileSystem();
        $repository = new Repository($git, $fileSystem);
        $ignore = $repository->ignore();

        self::assertFalse($ignore->has('test.txt'));

        $ignore->add('test.txt');

        self::assertTrue($fileSystem->exists($ignore->getPathToFile()));
        self::assertEquals('test.txt', $fileSystem->getFileContent($ignore->getPathToFile()));
        self::assertTrue($ignore->has('test.txt'));
    }
}
