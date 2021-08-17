<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Commands;

use ArtARTs36\GitHandler\Command\Groups\FileCommand;
use ArtARTs36\GitHandler\Tests\Unit\V2TestCase;

final class FileCommandTest extends V2TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\FileCommand::createFile
     */
    public function testCreateFileWithoutFolder(): void
    {
        $this->makeFileCommand()->createFile('file.txt', 'file');

        self::assertTrue($this->mockFileSystem->exists($this->mockGitContext->getRootDir() . '/file.txt'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\FileCommand::createFile
     * @covers \ArtARTs36\GitHandler\Command\Groups\FileCommand::createFolder
     */
    public function testCreateFileWithFolder(): void
    {
        $this->makeFileCommand()->createFile('file.txt', 'file', 'folder1');

        self::assertTrue($this->mockFileSystem->exists($this->mockGitContext->getRootDir() . '/folder1/file.txt'));
    }

    private function makeFileCommand(): FileCommand
    {
        return new FileCommand($this->mockFileSystem, $this->mockGitContext);
    }
}
