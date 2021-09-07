<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Commands;

use ArtARTs36\GitHandler\Command\Commands\FileCommand;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;

final class FileCommandTest extends GitTestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\FileCommand::createFile
     */
    public function testCreateFileWithoutFolder(): void
    {
        $this->makeFileCommand()->createFile('file.txt', 'file');

        self::assertTrue($this->mockFileSystem->exists($this->mockGitContext->getRootDir() . '/file.txt'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\FileCommand::createFile
     * @covers \ArtARTs36\GitHandler\Command\Commands\FileCommand::createFolder
     */
    public function testCreateFileWithFolder(): void
    {
        $this->makeFileCommand()->createFile('file.txt', 'file', 'folder1');

        self::assertTrue($this->mockFileSystem->exists($this->mockGitContext->getRootDir() . '/folder1/file.txt'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\FileCommand::getContent
     */
    public function testGetContent(): void
    {
        $command = $this->makeFileCommand();

        $this->mockFileSystem->createFile(
            $this->mockGitContext->getRootDir() . DIRECTORY_SEPARATOR . 'file.txt',
            '123'
        );

        self::assertEquals('123', $command->getContent('file.txt'));
    }

    private function makeFileCommand(): FileCommand
    {
        return new FileCommand($this->mockFileSystem, $this->mockGitContext);
    }
}
