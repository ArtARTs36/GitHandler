<?php

namespace ArtARTs36\GitHandler;

use ArtARTs36\GitHandler\Command\GitCommandBuilder;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitHelpCommandGroup;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitPathCommandGroup;
use ArtARTs36\GitHandler\Command\Groups\HelpCommandGroup;
use ArtARTs36\GitHandler\Command\Groups\PathCommandGroup;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandExecutor;

class GitV2
{
    protected $commandBuilder;

    protected $executor;

    protected $dir;

    public function __construct(
        GitCommandBuilder $builder,
        ShellCommandExecutor $executor,
        string $dir
    ) {
        $this->commandBuilder = $builder;
        $this->executor = $executor;
        $this->dir = $dir;
    }

    public function helps(): GitHelpCommandGroup
    {
        return new HelpCommandGroup($this->commandBuilder, $this->executor);
    }

    public function paths(): GitPathCommandGroup
    {
        return new PathCommandGroup($this->commandBuilder, $this->executor);
    }
}
