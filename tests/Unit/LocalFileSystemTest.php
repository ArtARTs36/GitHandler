<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Exceptions\FileNotFound;
use ArtARTs36\GitHandler\Exceptions\PathIncorrect;
use ArtARTs36\GitHandler\Support\LocalFileSystem;

final class LocalFileSystemTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Support\LocalFileSystem::getFromDirectory
     */
    public function testGetFromDirectory(): void
    {
        $fileSystem = new LocalFileSystem();
        $path = realpath(__DIR__ . '/../Mocks/files/local_file_system_test/get_from_directory') . '/';

        $result = $fileSystem->getFromDirectory($path);

        self::assertEquals([$path. '1.txt', $path. '2.txt'], $result);
    }

    /**
     * @covers \ArtARTs36\GitHandler\Support\LocalFileSystem::removeDir
     */
    public function testRemoveDir(): void
    {
        $fileSystem = new LocalFileSystem();

        self::assertTrue($fileSystem->removeDir(random_bytes(6). '/random/path'));
    }

    public function providerForTestDownPath(): array
    {
        return [
            [
                __DIR__, realpath(__DIR__ . '/../'),
            ],
            [
                '/path/to/git', '/path/to',
            ],
        ];
    }

    /**
     * @dataProvider providerForTestDownPath
     * @covers \ArtARTs36\GitHandler\Support\LocalFileSystem::downPath
     */
    public function testDownPath(string $input, string $expected): void
    {
        $fileSystem = new LocalFileSystem();

        self::assertEquals($expected, $fileSystem->downPath($input));
    }

    public function providerForTestExists(): array
    {
        return [
            [
                __FILE__,
                true,
            ],
            [
                'random-file',
                false,
            ],
            [
                __DIR__ . '/../Mocks/files/local_file_system_test/exists/on_link/link-dir/1.txt',
                true,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestExists
     * @covers \ArtARTs36\GitHandler\Support\LocalFileSystem::exists
     */
    public function testExists(string $file, bool $expected): void
    {
        $fileSystem = new LocalFileSystem();

        self::assertEquals($expected, $fileSystem->exists($file));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Support\LocalFileSystem::getFileContent
     * @covers \ArtARTs36\GitHandler\Support\LocalFileSystem::raiseFileNotFoundIfNotExists
     */
    public function testGetFileContentOnNotFound(): void
    {
        $fileSystem = new LocalFileSystem();

        //

        self::expectException(FileNotFound::class);

        $fileSystem->getFileContent('random-file');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Support\LocalFileSystem::getFileContent
     * @covers \ArtARTs36\GitHandler\Support\LocalFileSystem::raiseFileNotFoundIfNotExists
     */
    public function testGetFileContentOnGood(): void
    {
        $system = new LocalFileSystem();

        $path = __DIR__ . '/../Mocks/files/local_file_system_test/get_from_directory/1.txt';

        self::assertEquals(1, $system->getFileContent($path));
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

    /**
     * @covers \ArtARTs36\GitHandler\Support\LocalFileSystem::__construct
     */
    public function testConstructor(): void
    {
        $system = new LocalFileSystem();

        self::assertEquals('filemtime', $this->getPropertyValueOfObject($system, 'fileDateGetter'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Support\LocalFileSystem::createFile
     */
    public function testCreateFile(): void
    {
        $system = new LocalFileSystem();

        $path = __DIR__ . '/../Mocks/files/local_file_system_test/test_create_file.txt';

        $system->createFile($path, 'ss');

        self::assertFileExists($path);

        $system->removeFile($path);
    }

    /**
     * @covers \ArtARTs36\GitHandler\Support\LocalFileSystem::createDir
     */
    public function testCreateDir(): void
    {
        $system = new LocalFileSystem();

        $path = __DIR__ . '/../Mocks/files/local_file_system_test/test_create_file';

        $system->createDir($path);

        self::assertFileExists($path);

        $system->removeDir($path);
    }

    /**
     * @covers \ArtARTs36\GitHandler\Support\LocalFileSystem::createDir
     */
    public function testCreateDirOnExists(): void
    {
        $system = new LocalFileSystem();

        $path = __DIR__ . '/../Mocks/files/local_file_system_test/test_create_file';

        $system->createDir($path);

        self::assertFileExists($path);
        self::assertTrue($system->createDir($path));

        $system->removeDir($path);
    }

    public function providerForTestRemoveDirOn2Level(): array
    {
        return [
            [
                __DIR__ . '/../Mocks/files/test_remove_dir',
                [
                    'folder' => [
                        ['file1.txt', 'ss'],
                        ['file2.txt', 'ss'],
                        ['ignore', 'no-content'],
                    ]
                ],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\GitHandler\Support\LocalFileSystem::removeDir
     * @dataProvider providerForTestRemoveDirOn2Level
     */
    public function testRemoveDirOn2Level(string $directory, array $files): void
    {
        $system = new LocalFileSystem();

        //

        foreach ($files as $folder => $names) {
            $system->createDir($dir = $directory . DIRECTORY_SEPARATOR . $folder);

            foreach ($names as [$file, $content]) {
                file_put_contents($dir . DIRECTORY_SEPARATOR . $file, $content);
            }
        }

        $system->removeDir($directory);

        self::assertFileDoesNotExist($directory);
    }

    /**
     * @covers \ArtARTs36\GitHandler\Support\LocalFileSystem::removeDir
     */
    public function testRemoveDirExistsUndefined(): void
    {
        $system = new class extends LocalFileSystem {
            public function exists(string $path): bool
            {
                return true;
            }
        };

        self::assertTrue($system->removeDir('random-ath'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Support\LocalFileSystem::getTmpDir
     */
    public function testGetTmpDir(): void
    {
        $fileSystem = new LocalFileSystem();

        self::assertEquals(sys_get_temp_dir(), $fileSystem->getTmpDir());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Support\LocalFileSystem::getAbsolutePath
     */
    public function testGetAbsolutePathOnFileNotFound(): void
    {
        $fileSystem = new LocalFileSystem();

        self::expectException(FileNotFound::class);

        $fileSystem->getAbsolutePath('random-path');
    }

    public function providerForTestGetAbsolutePath(): array
    {
        return [
            [__DIR__ . '/../functions.php', dirname(__DIR__) . '/functions.php']
        ];
    }

    /**
     * @dataProvider providerForTestGetAbsolutePath
     * @covers \ArtARTs36\GitHandler\Support\LocalFileSystem::getAbsolutePath
     */
    public function testGetAbsolutePath(string $input, string $expected): void
    {
        self::assertEquals($expected, (new LocalFileSystem())->getAbsolutePath($input));
    }
}
