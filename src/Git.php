<?php

namespace ArtARTs36\GitHandler;

use ArtARTs36\GitHandler\Command\GitCommandBuilder;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitPullCommand;
use ArtARTs36\GitHandler\Command\Groups\IndexCommand;
use ArtARTs36\GitHandler\Command\Groups\BranchCommand;
use ArtARTs36\GitHandler\Command\Groups\CommitCommand;
use ArtARTs36\GitHandler\Command\Groups\ConfigCommand;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitIndexCommand;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitBranchCommand;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitCommitCommand;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitConfigCommand;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitGrepCommand;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitHelpCommand;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitHookCommand;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitIgnoreCommand;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitInitCommand;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitLogCommand;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitPathCommand;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitPushCommand;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitRemoteCommand;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitStashCommand;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitStatusCommand;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitTagCommand;
use ArtARTs36\GitHandler\Command\Groups\GrepCommand;
use ArtARTs36\GitHandler\Command\Groups\HelpCommand;
use ArtARTs36\GitHandler\Command\Groups\HookCommand;
use ArtARTs36\GitHandler\Command\Groups\IgnoreCommand;
use ArtARTs36\GitHandler\Command\Groups\InitCommand;
use ArtARTs36\GitHandler\Command\Groups\LogCommand;
use ArtARTs36\GitHandler\Command\Groups\PathCommand;
use ArtARTs36\GitHandler\Command\Groups\PullCommand;
use ArtARTs36\GitHandler\Command\Groups\PushCommand;
use ArtARTs36\GitHandler\Command\Groups\RemoteCommand;
use ArtARTs36\GitHandler\Command\Groups\StashCommand;
use ArtARTs36\GitHandler\Command\Groups\StatusCommand;
use ArtARTs36\GitHandler\Command\Groups\TagCommand;
use ArtARTs36\GitHandler\Config\Configurators\BranchConfigurator;
use ArtARTs36\GitHandler\Config\Configurators\CoreConfigurator;
use ArtARTs36\GitHandler\Config\Configurators\CredentialConfigurator;
use ArtARTs36\GitHandler\Config\Configurators\PackConfigurator;
use ArtARTs36\GitHandler\Config\Configurators\UserConfigurator;
use ArtARTs36\GitHandler\Config\ConfiguratorsDict;
use ArtARTs36\GitHandler\Config\RegexConfigResultParser;
use ArtARTs36\GitHandler\Contracts\FileSystem;
use ArtARTs36\GitHandler\Contracts\Handler\GitHandler;
use ArtARTs36\GitHandler\Data\GitContext;
use ArtARTs36\GitHandler\Data\Version;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandExecutor;
use ArtARTs36\Str\Str;

class Git implements GitHandler
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

    public function helps(): GitHelpCommand
    {
        return new HelpCommand($this->commandBuilder, $this->executor);
    }

    public function paths(): GitPathCommand
    {
        return new PathCommand($this->commandBuilder, $this->executor);
    }

    public function tags(): GitTagCommand
    {
        return new TagCommand($this->commandBuilder, $this->executor);
    }

    public function hooks(): GitHookCommand
    {
        return new HookCommand(
            $this->fileSystem,
            $this->executor,
            $this->context
        );
    }

    public function logs(): GitLogCommand
    {
        return new LogCommand(new Logger(), $this->commandBuilder, $this->executor);
    }

    public function greps(): GitGrepCommand
    {
        return new GrepCommand($this->commandBuilder, $this->executor);
    }

    public function inits(): GitInitCommand
    {
        return new InitCommand(
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

    public function index(): GitIndexCommand
    {
        return new IndexCommand($this->commandBuilder, $this->executor);
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
            $this->index(),
            $this->statuses(),
            $this->commandBuilder,
            $this->executor
        );
    }

    public function stashes(): GitStashCommand
    {
        return new StashCommand($this->commandBuilder, $this->executor);
    }

    public function config(): GitConfigCommand
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

    public function version(): Version
    {
        $result = $this
            ->commandBuilder
            ->make()
            ->addOption('version')
            ->executeOrFail($this->executor)
            ->getResult()
            ->trim();

        return new Version($result, ...array_map(function (Str $str) {
            return $str->toInteger();
        }, $result->match('/([0-9]+.[0-9]+.[0-9]+)/i')->sentences()));
    }

    public function delete(): bool
    {
        return $this->fileSystem->removeDir($this->context->getRootDir());
    }

    public function pulls(): GitPullCommand
    {
        return new PullCommand($this->commandBuilder, $this->executor);
    }
}
