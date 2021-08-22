<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Commands;

use ArtARTs36\GitHandler\Command\Commands\IgnoreCommand;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;

final class IgnoreCommandTest extends GitTestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\IgnoreCommand::files
     */
    public function testFilesEmptyOnNotExistsIgnoreFile(): void
    {
        $command = $this->makeIgnoreCommand();

        self::assertEquals([], $command->files());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\IgnoreCommand::files
     */
    public function testFiles(): void
    {
        $command = $this->makeIgnoreCommand();

        $this->mockFileSystem->createFile($command->getPath(), "index.php\nfile.php");

        self::assertEquals([
            'index.php',
            'file.php',
        ], $command->files());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\IgnoreCommand::add
     */
    public function testAddOnEmptyFile(): void
    {
        $command = $this->makeIgnoreCommand();

        $command->add('index.php');

        self::assertTrue($this->mockFileSystem->exists($command->getPath()));
        self::assertEquals("index.php", $this->mockFileSystem->getFileContent($command->getPath()));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\IgnoreCommand::add
     */
    public function testAddOnFilledFile(): void
    {
        $command = $this->makeIgnoreCommand();

        $this->mockFileSystem->createFile($command->getPath(), "file.php");

        $command->add('index.php');

        self::assertEquals("file.php\nindex.php", $this->mockFileSystem->getFileContent($command->getPath()));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\IgnoreCommand::has
     * @covers \ArtARTs36\GitHandler\Command\Commands\IgnoreCommand::isFileExists
     */
    public function testHas(): void
    {
        $command = $this->makeIgnoreCommand();

        $this->mockFileSystem->createFile($command->getPath(), 'index.php');

        self::assertTrue($command->has('index.php'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\IgnoreCommand::has
     * @covers \ArtARTs36\GitHandler\Command\Commands\IgnoreCommand::isFileExists
     */
    public function testHasOnNotExistsIgnoreFile(): void
    {
        $command = $this->makeIgnoreCommand();

        self::assertFalse($command->has('index.php'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\IgnoreCommand::delete
     */
    public function testDeleteOnFileNotExists(): void
    {
        $command = $this->makeIgnoreCommand();

        self::assertFalse($command->delete('file1.txt'));
    }

    public function providerForTestDelete(): array
    {
        return [
            [
                "file1.txt\ncomposer.lock\nfile2.txt",
                'composer.lock',
                "file1.txt\nfile2.txt",
            ],
        ];
    }

    /**
     * @dataProvider providerForTestDelete
     * @covers \ArtARTs36\GitHandler\Command\Commands\IgnoreCommand::delete
     */
    public function testDelete(string $startContent, string $path, string $endContent): void
    {
        $command = $this->makeIgnoreCommand();

        $this->mockFileSystem->createFile($command->getPath(), $startContent);

        $command->delete($path);

        self::assertEquals($endContent, $this->mockFileSystem->getFileContent($command->getPath()));
    }

    private function makeIgnoreCommand(): IgnoreCommand
    {
        return new IgnoreCommand($this->mockGitContext, $this->mockFileSystem);
    }
}
