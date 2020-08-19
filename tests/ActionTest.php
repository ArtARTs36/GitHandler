<?php

namespace ArtARTs36\GitHandler\Tests;

use ArtARTs36\GitHandler\Action;
use ArtARTs36\GitHandler\Git;
use ArtARTs36\GitHandler\Support\FileSystem;
use PHPUnit\Framework\TestCase;

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

        $git = new Git($dir);

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

    private function mock(): Action
    {
        $dir = $this->getTmpDir();

        $git = new Git($dir);

        return new Action($git);
    }

    private function getTmpDir(): string
    {
        return __DIR__ . '/../' . '__tmp';
    }
}
