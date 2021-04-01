<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Repository;
use ArtARTs36\GitHandler\GitSimpleFactory;

class ActionTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->fileSystem->createDir($this->getTmpDir());
    }

    public function tearDown(): void
    {
        parent::tearDown();

        $this->fileSystem->removeDir($this->getTmpDir());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Repository::createFolder
     */
    public function testCreateFolder(): void
    {
        $dir = $this->getTmpDir();

        $git = GitSimpleFactory::factory($dir);

        $action = new Repository($git, $this->fileSystem);

        $action->createFolder('test');

        //);

        self::assertTrue($this->fileSystem->exists($dir . DIRECTORY_SEPARATOR . 'test'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Repository::createFile
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

    /**
     * @covers \ArtARTs36\GitHandler\Repository::delete
     */
    public function testDelete(): void
    {
        $action = $this->mock();

        self::assertTrue($this->fileSystem->exists($this->getTmpDir()));

        //

        $action->delete();

        self::assertFalse($this->fileSystem->exists($this->getTmpDir()));
    }

    private function mock(): Repository
    {
        $dir = $this->getTmpDir();

        $git = GitSimpleFactory::factory($dir, $this->fileSystem);

        return new Repository($git, $this->fileSystem);
    }

    private function getTmpDir(): string
    {
        return __DIR__ . '/git/' . '__tmp';
    }
}
