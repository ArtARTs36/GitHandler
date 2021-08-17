<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Commands;

use ArtARTs36\GitHandler\Command\Commands\CloneCommand;
use ArtARTs36\GitHandler\Data\GitContext;
use ArtARTs36\GitHandler\Exceptions\PathAlreadyExists;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;

final class CloneCommandTest extends GitTestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\CloneCommand::clone
     */
    public function testCloneOk(): void
    {
        $this->mockGitContext = GitContext::make('/var/web/project');
        $folder = 'project';
        $url = 'http://url.git';

        //

        $this->mockCommandExecutor->nextOk("Cloning into '{$folder}' ...");

        self::assertTrue($this->makeCloneCommand()->clone($url));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\CloneCommand::clone
     */
    public function testCloneOnPathAlreadyExists(): void
    {
        $this->mockGitContext = GitContext::make('/var/web/project');
        $folder = 'project';
        $url = 'http://url.git';

        self::expectException(PathAlreadyExists::class);

        $this->mockCommandExecutor->nextFailed("fatal: destination path '{$folder}' already exists " .
            "and is not an empty directory.");

        $this->makeCloneCommand()->clone($url, 'master');
    }

    private function makeCloneCommand(): CloneCommand
    {
        return new CloneCommand(
            $this->mockFileSystem,
            $this->mockGitContext,
            $this->mockCommandBuilder,
            $this->mockCommandExecutor
        );
    }
}
