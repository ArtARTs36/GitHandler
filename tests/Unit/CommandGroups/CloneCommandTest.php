<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Command\Groups\CloneCommand;
use ArtARTs36\GitHandler\Exceptions\PathAlreadyExists;
use ArtARTs36\GitHandler\GitContext;

final class CloneCommandTest extends V2TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\CloneCommand::clone
     */
    public function testCloneOk(): void
    {
        $this->mockGitContext = GitContext::make($dir ='/var/web/project');
        $folder = 'project';
        $url = 'http://url.git';

        //

        $this->mockCommandExecutor->nextOk("Cloning into '{$folder}' ...");

        self::assertTrue($this->makeCloneCommand()->clone($url));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\CloneCommand::clone
     */
    public function testCloneOnPathAlreadyExists(): void
    {
        $this->mockGitContext = GitContext::make($dir ='/var/web/project');
        $folder = 'project';
        $url = 'http://url.git';

        self::expectException(PathAlreadyExists::class);

        $this->mockCommandExecutor->nextFailed("fatal: destination path '{$folder}' already exists " .
            "and is not an empty directory.");

        $this->makeCloneCommand()->clone($url);
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
