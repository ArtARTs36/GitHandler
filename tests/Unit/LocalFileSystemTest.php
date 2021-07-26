<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Exceptions\FileNotFound;
use ArtARTs36\GitHandler\Exceptions\PathIncorrect;
use ArtARTs36\GitHandler\Support\LocalFileSystem;

class LocalFileSystemTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Support\LocalFileSystem::getFromDirectory
     */
    public function testGetFromDirectory(): void
    {
        $fileSystem = new LocalFileSystem();
        $path = __DIR__ . '/../Mocks/files/local_file_system_test/get_from_directory';

        $result = $fileSystem->getFromDirectory($path);

        self::assertCount(2, $result);
        self::assertStringContainsString('1.txt', $result[0]);
        self::assertStringContainsString('2.txt', $result[1]);
    }

    /**
     * @covers \ArtARTs36\GitHandler\Support\LocalFileSystem::removeDir
     */
    public function testRemoveDir(): void
    {
        $fileSystem = new LocalFileSystem();

        self::assertTrue($fileSystem->removeDir(random_bytes(6). '/random/path'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Support\LocalFileSystem::belowPath
     */
    public function testBelowPath(): void
    {
        $fileSystem = new LocalFileSystem();

        $expected = realpath(__DIR__ . '/../');

        self::assertEquals($expected, $fileSystem->belowPath(__DIR__));

        //

        self::assertEquals('/path/to', $fileSystem->belowPath('/path/to/git'));

        //

        self::expectException(PathIncorrect::class);

        $fileSystem->belowPath('------test');
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

    /**
     * @covers \ArtARTs36\GitHandler\Support\LocalFileSystem::getFileContent
     */
    public function testGetFileContent(): void
    {
        $fileSystem = new LocalFileSystem();

        //

        self::expectException(FileNotFound::class);

        $fileSystem->getFileContent('random-file');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Support\LocalFileSystem::removeFile
     */
    public function testRemoveFileOnNotExists(): void
    {
        self::expectException(FileNotFound::class);

        (new LocalFileSystem())->removeFile('random-file');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Support\LocalFileSystem::removeFile
     */
    public function testRemoveFileGood(): void
    {
        $system = new LocalFileSystem();

        $path = __DIR__ . '/../Mocks/files/local_file_system_test/1.txt';

        $system->createFile($path, 'ss');

        self::assertTrue($system->removeFile($path));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Support\LocalFileSystem::getLastUpdateDate
     */
    public function testGetLastUpdateDateGood(): void
    {
        $system = new LocalFileSystem(function () {
            return 1627258440;
        });

        self::assertEquals(1627258440, $system->getLastUpdateDate(__FILE__)->getTimestamp());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Support\LocalFileSystem::getLastUpdateDate
     */
    public function testGetLastUpdateDateOnNotExists(): void
    {
        self::expectException(FileNotFound::class);

        (new LocalFileSystem())->getLastUpdateDate('random-file');
    }
}
