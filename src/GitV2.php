<?php

namespace ArtARTs36\GitHandler;

use ArtARTs36\GitHandler\Command\GitCommandBuilder;
use ArtARTs36\GitHandler\Command\Groups\AddCommand;
use ArtARTs36\GitHandler\Command\Groups\BranchCommand;
use ArtARTs36\GitHandler\Command\Groups\CommitCommand;
use ArtARTs36\GitHandler\Command\Groups\ConfigCommand;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitAddCommand;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitBranchCommand;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitCommitCommand;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitConfigCommand;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitGrepCommandGroup;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitHelpCommandGroup;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitHookCommandGroup;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitIgnoreCommand;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitInitCommandGroup;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitLogCommandGroup;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitPathCommandGroup;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitPushCommand;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitRemoteCommand;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitStashCommand;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitStatusCommand;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitTagCommandGroup;
use ArtARTs36\GitHandler\Command\Groups\GrepGroupCommand;
use ArtARTs36\GitHandler\Command\Groups\HelpCommandGroup;
use ArtARTs36\GitHandler\Command\Groups\HookCommandGroup;
use ArtARTs36\GitHandler\Command\Groups\IgnoreCommand;
use ArtARTs36\GitHandler\Command\Groups\InitCommandGroup;
use ArtARTs36\GitHandler\Command\Groups\LogCommandGroup;
use ArtARTs36\GitHandler\Command\Groups\PathCommandGroup;
use ArtARTs36\GitHandler\Command\Groups\PushCommand;
use ArtARTs36\GitHandler\Command\Groups\RemoteCommand;
use ArtARTs36\GitHandler\Command\Groups\StashCommand;
use ArtARTs36\GitHandler\Command\Groups\StatusCommand;
use ArtARTs36\GitHandler\Command\Groups\TagCommandGroup;
use ArtARTs36\GitHandler\Config\Configurators\BranchConfigurator;
use ArtARTs36\GitHandler\Config\Configurators\CoreConfigurator;
use ArtARTs36\GitHandler\Config\Configurators\CredentialConfigurator;
use ArtARTs36\GitHandler\Config\Configurators\PackConfigurator;
use ArtARTs36\GitHandler\Config\Configurators\UserConfigurator;
use ArtARTs36\GitHandler\Config\ConfiguratorsDict;
use ArtARTs36\GitHandler\Config\RegexConfigResultParser;
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

    public function getContext(): GitContext
    {
        return $this->context;
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

    public function inits(): GitInitCommandGroup
    {
        return new InitCommandGroup(
            $this->fileSystem,
            $this->context,
            $this->commandBuilder,
            $this->executor
        );
    }

    public function branches(): GitBranchCommand
    {
        return new BranchCommand($this->commandBuilder, $this->executor);
    }

    public function adds(): GitAddCommand
    {
        return new AddCommand($this->commandBuilder, $this->executor);
    }

    public function pushes(): GitPushCommand
    {
        return new PushCommand($this->branches(), $this->commandBuilder, $this->executor);
    }

    public function statuses(): GitStatusCommand
    {
        return new StatusCommand($this->commandBuilder, $this->executor);
    }

    public function commits(): GitCommitCommand
    {
        return new CommitCommand(
            $this->adds(),
            $this->statuses(),
            $this->commandBuilder,
            $this->executor
        );
    }

    public function stashes(): GitStashCommand
    {
        return new StashCommand($this->commandBuilder, $this->executor);
    }

    public function configs(): GitConfigCommand
    {
        return new ConfigCommand(
            new RegexConfigResultParser(
                ConfiguratorsDict::make([
                    new UserConfigurator(),
                    new CoreConfigurator(),
                    new PackConfigurator(),
                    new CredentialConfigurator(),
                    new BranchConfigurator(),
                ])
            ),
            $this->commandBuilder,
            $this->executor,
        );
    }

    public function remotes(): GitRemoteCommand
    {
        return new RemoteCommand(
            $this->commandBuilder,
            $this->executor,
        );
    }

    public function ignores(): GitIgnoreCommand
    {
        return new IgnoreCommand(
            $this->context,
            $this->fileSystem
        );
    }
}
