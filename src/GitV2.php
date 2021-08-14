<?php

namespace ArtARTs36\GitHandler;

use ArtARTs36\GitHandler\Command\GitCommandBuilder;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitGrepCommandGroup;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitHelpCommandGroup;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitHookCommandGroup;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitLogCommandGroup;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitPathCommandGroup;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitTagCommandGroup;
use ArtARTs36\GitHandler\Command\Groups\GrepGroupCommand;
use ArtARTs36\GitHandler\Command\Groups\HelpCommandGroup;
use ArtARTs36\GitHandler\Command\Groups\HookCommandGroup;
use ArtARTs36\GitHandler\Command\Groups\LogCommandGroup;
use ArtARTs36\GitHandler\Command\Groups\PathCommandGroup;
use ArtARTs36\GitHandler\Command\Groups\TagCommandGroup;
use ArtARTs36\GitHandler\Contracts\FileSystem;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandExecutor;

class GitV2
{
    protected $commandBuilder;

    protected $executor;

    protected $fileSystem;

    protected $context;

    public function __construct(
        GitCommandBuilder $builder,
        ShellCommandExecutor $executor,
        FileSystem $fileSystem,
        GitContext $context
    ) {
        $this->commandBuilder = $builder;
        $this->executor = $executor;
        $this->fileSystem = $fileSystem;
        $this->context = $context;
    }

    public function helps(): GitHelpCommandGroup
    {
        return new HelpCommandGroup($this->commandBuilder, $this->executor);
    }

    public function paths(): GitPathCommandGroup
    {
        return new PathCommandGroup($this->commandBuilder, $this->executor);
    }

    public function tags(): GitTagCommandGroup
    {
        return new TagCommandGroup($this->commandBuilder, $this->executor);
    }

    public function hooks(): GitHookCommandGroup
    {
        return new HookCommandGroup(
            $this->fileSystem,
            $this->executor,
            $this->context
        );
    }

    public function logs(): GitLogCommandGroup
    {
        return new LogCommandGroup(new Logger(), $this->commandBuilder, $this->executor);
    }

    public function greps(): GitGrepCommandGroup
    {
        return new GrepGroupCommand($this->commandBuilder, $this->executor);
    }
}
