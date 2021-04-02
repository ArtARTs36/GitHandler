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
     * @covers \ArtARTs36\GitHandler\Ignore::files
     */
    public function testAdd(): void
    {
        $git = GitSimpleFactory::factory(__DIR__);
        $fileSystem = new ArrayFileSystem();
        $repository = new Repository($git, $fileSystem);
        $ignore = $repository->ignore();

        self::assertFalse($ignore->has('test.txt'));
        self::assertEquals([], $ignore->files());

        $ignore->add('test.txt');

        self::assertTrue($fileSystem->exists($ignore->getPathToFile()));
        self::assertEquals('test.txt', $fileSystem->getFileContent($ignore->getPathToFile()));
        self::assertTrue($ignore->has('test.txt'));
        self::assertEquals(['test.txt'], $ignore->files());

        // test if .gitignore - non-empty

        $ignore->add('file.txt');

        self::assertEquals("test.txt\nfile.txt", $fileSystem->getFileContent($ignore->getPathToFile()));
    }
}
