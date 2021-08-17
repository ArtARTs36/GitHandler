<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Commands;

use ArtARTs36\GitHandler\Command\Groups\IgnoreCommand;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;

final class IgnoreCommandTest extends GitTestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\IgnoreCommand::files
     */
    public function testFilesEmptyOnNotExistsIgnoreFile(): void
    {
        $command = $this->makeIgnoreCommand();

        self::assertEquals([], $command->files());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\IgnoreCommand::files
     */
    public function testFiles(): void
    {
        $command = $this->makeIgnoreCommand();

        $this->mockFileSystem->createFile($command->getPathToFile(), "index.php\nfile.php");

        self::assertEquals([
            'index.php',
            'file.php',
        ], $command->files());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\IgnoreCommand::add
     */
    public function testAddOnEmptyFile(): void
    {
        $command = $this->makeIgnoreCommand();

        $command->add('index.php');

        self::assertTrue($this->mockFileSystem->exists($command->getPathToFile()));
        self::assertEquals("index.php", $this->mockFileSystem->getFileContent($command->getPathToFile()));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\IgnoreCommand::add
     */
    public function testAddOnFilledFile(): void
    {
        $command = $this->makeIgnoreCommand();

        $this->mockFileSystem->createFile($command->getPathToFile(), "file.php");

        $command->add('index.php');

        self::assertEquals("file.php\nindex.php", $this->mockFileSystem->getFileContent($command->getPathToFile()));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\IgnoreCommand::has
     */
    public function testHas(): void
    {
        $command = $this->makeIgnoreCommand();

        $this->mockFileSystem->createFile($command->getPathToFile(), 'index.php');

        self::assertTrue($command->has('index.php'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\IgnoreCommand::has
     */
    public function testHasOnNotExistsIgnoreFile(): void
    {
        $command = $this->makeIgnoreCommand();

        self::assertFalse($command->has('index.php'));
    }

    private function makeIgnoreCommand(): IgnoreCommand
    {
        return new IgnoreCommand($this->mockGitContext, $this->mockFileSystem);
    }
}
