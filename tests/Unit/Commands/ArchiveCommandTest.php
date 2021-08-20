<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Commands;

use ArtARTs36\GitHandler\Command\Commands\ArchiveCommand;
use ArtARTs36\GitHandler\Exceptions\PathIsDirectoryNotCould;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;

final class ArchiveCommandTest extends GitTestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\ArchiveCommand::create
     */
    public function testCreateWithPathDir(): void
    {
        $this->mockCommandExecutor->nextFailed('fatal: could not create archive file \'var.zip\': Is a directory');

        self::expectException(PathIsDirectoryNotCould::class);

        $this->makeArchiveCommand()->create('var.zip');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\ArchiveCommand::create
     */
    public function testCreateOk(): void
    {
        $this->mockCommandExecutor->nextOk();

        self::assertNull($this->makeArchiveCommand()->create('var.zip'));
    }

    private function makeArchiveCommand(): ArchiveCommand
    {
        return new ArchiveCommand(
            $this->mockFileSystem,
            $this->mockGitContext,
            $this->mockCommandBuilder,
            $this->mockCommandExecutor
        );
    }
}
