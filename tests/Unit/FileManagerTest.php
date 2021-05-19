<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Files\FileManager;
use ArtARTs36\GitHandler\Repository;
use ArtARTs36\GitHandler\GitSimpleFactory;

class FileManagerTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Files\FileManager::createFolder
     */
    public function testCreateFolder(): void
    {
        $action = $this->mock();

        $action->createFolder('test');

        //

        self::assertTrue($this->fileSystem->exists($this->getTmpDir() . DIRECTORY_SEPARATOR . 'test'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Files\FileManager::createFile
     */
    public function testCreateFile(): void
    {
        $action = $this->mock();

        $action->createFile('test.php', 'echo hello world');

        self::assertTrue($this->fileSystem->exists($this->getTmpDir() . DIRECTORY_SEPARATOR . 'test.php'));

        //

        $action->createFile('test.php', 'echo hello world', 'test');

        self::assertTrue($this->fileSystem->exists(
            $this->getTmpDir() . DIRECTORY_SEPARATOR . 'test' . DIRECTORY_SEPARATOR . 'test.php'
        ));
    }

    private function mock(): FileManager
    {
        $dir = $this->getTmpDir();

        $git = GitSimpleFactory::factory($dir, $this->fileSystem);

        return $git->files()->manager();
    }

    /**
     * @covers \ArtARTs36\GitHandler\Files\FileManager::deleteFile
     */
    public function testDelete(): void
    {
        $manager = $this->mock();

        $this->fileSystem->createFile($this->getTmpDir() . '/test', '');

        $manager->deleteFile('test');

        self::assertFalse($this->fileSystem->exists($this->getTmpDir(). '/test'));
    }
}
