<?php

namespace ArtARTs36\GitHandler\Tests;

use ArtARTs36\GitHandler\Action;
use ArtARTs36\GitHandler\GitSimpleFactory;
use ArtARTs36\GitHandler\Support\FileSystem;

class ActionTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        mkdir($this->getTmpDir());
    }

    public function tearDown(): void
    {
        parent::tearDown();

        FileSystem::removeDir($this->getTmpDir());
    }

    public function testCreateFolder(): void
    {
        $dir = $this->getTmpDir();

        $git = GitSimpleFactory::factory($dir);

        $action = new Action($git);

        $action->createFolder('test');

        //

        self::assertFileExists($dir . DIRECTORY_SEPARATOR . 'test');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Action::createFile
     */
    public function testCreateFile(): void
    {
        $action = $this->mock();

        $action->createFile('test.php', 'echo hello world');

        self::assertFileExists($this->getTmpDir() . DIRECTORY_SEPARATOR . 'test.php');

        //

        $action->createFile('test.php', 'echo hello world', 'test');

        self::assertFileExists(
            $this->getTmpDir() . DIRECTORY_SEPARATOR . 'test' . DIRECTORY_SEPARATOR . 'test.php'
        );
    }

    /**
     * @covers \ArtARTs36\GitHandler\Action::delete
     */
    public function testDelete(): void
    {
        $action = $this->mock();

        self::assertFileExists($this->getTmpDir());

        //

        $action->delete();

        self::assertFileDoesNotExist($this->getTmpDir());
    }

    private function mock(): Action
    {
        $dir = $this->getTmpDir();

        $git = GitSimpleFactory::factory($dir);

        return new Action($git);
    }

    private function getTmpDir(): string
    {
        return __DIR__ . '/../' . '__tmp';
    }
}
