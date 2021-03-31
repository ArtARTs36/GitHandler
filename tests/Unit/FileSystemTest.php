<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Support\LocalFileSystem;

class FileSystemTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Support\LocalFileSystem::belowPath
     */
    public function testBelowPath(): void
    {
        $fileSystem = new LocalFileSystem();

        $expected = realpath(__DIR__ . '/../');

        self::assertEquals($expected, $fileSystem->belowPath(__DIR__));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Support\LocalFileSystem::endFolder
     */
    public function testEndFolder(): void
    {
        $fileSystem = new LocalFileSystem();

        self::assertEquals('Unit', $fileSystem->endFolder(__DIR__));
        self::assertEquals('Unit', $fileSystem->endFolder(__FILE__));

        self::assertEquals('tests', $fileSystem->endFolder('/path/to/tests'));
        self::assertEquals('tests', $fileSystem->endFolder('/path/to/tests/image.jpeg'));
        self::assertEquals('', $fileSystem->endFolder('image.jpeg'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Support\LocalFileSystem::isPseudoFile
     */
    public function testIsPseudoFile(): void
    {
        $fileSystem = new LocalFileSystem();

        self::assertFalse($fileSystem->isPseudoFile('image'));
        self::assertTrue($fileSystem->isPseudoFile('image.jpeg'));
        self::assertTrue($fileSystem->isPseudoFile('super.image.jpeg'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Support\LocalFileSystem::exists
     */
    public function testExists(): void
    {
        $fileSystem = new LocalFileSystem();

        self::assertTrue($fileSystem->exists(__FILE__));
        self::assertFalse($fileSystem->exists('random-file'));
    }
}
