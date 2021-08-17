<?php

namespace ArtARTs36\GitHandler;

use ArtARTs36\GitHandler\Command\Commands\ArchiveCommand;
use ArtARTs36\GitHandler\Command\GitCommandBuilder;
use ArtARTs36\GitHandler\Command\Commands\CloneCommand;
use ArtARTs36\GitHandler\Command\Commands\Contracts\GitCloneCommand;
use ArtARTs36\GitHandler\Command\Commands\Contracts\GitFileCommand;
use ArtARTs36\GitHandler\Command\Commands\Contracts\GitPullCommand;
use ArtARTs36\GitHandler\Command\Commands\FileCommand;
use ArtARTs36\GitHandler\Command\Commands\IndexCommand;
use ArtARTs36\GitHandler\Command\Commands\BranchCommand;
use ArtARTs36\GitHandler\Command\Commands\CommitCommand;
use ArtARTs36\GitHandler\Command\Commands\ConfigCommand;
use ArtARTs36\GitHandler\Command\Commands\Contracts\GitIndexCommand;
use ArtARTs36\GitHandler\Command\Commands\Contracts\GitBranchCommand;
use ArtARTs36\GitHandler\Command\Commands\Contracts\GitCommitCommand;
use ArtARTs36\GitHandler\Command\Commands\Contracts\GitConfigCommand;
use ArtARTs36\GitHandler\Command\Commands\Contracts\GitGrepCommand;
use ArtARTs36\GitHandler\Command\Commands\Contracts\GitHelpCommand;
use ArtARTs36\GitHandler\Command\Commands\Contracts\GitHookCommand;
use ArtARTs36\GitHandler\Command\Commands\Contracts\GitIgnoreCommand;
use ArtARTs36\GitHandler\Command\Commands\Contracts\GitInitCommand;
use ArtARTs36\GitHandler\Command\Commands\Contracts\GitLogCommand;
use ArtARTs36\GitHandler\Command\Commands\Contracts\GitPathCommand;
use ArtARTs36\GitHandler\Command\Commands\Contracts\GitPushCommand;
use ArtARTs36\GitHandler\Command\Commands\Contracts\GitRemoteCommand;
use ArtARTs36\GitHandler\Command\Commands\Contracts\GitStashCommand;
use ArtARTs36\GitHandler\Command\Commands\Contracts\GitStatusCommand;
use ArtARTs36\GitHandler\Command\Commands\Contracts\GitTagCommand;
use ArtARTs36\GitHandler\Command\Commands\GrepCommand;
use ArtARTs36\GitHandler\Command\Commands\HelpCommand;
use ArtARTs36\GitHandler\Command\Commands\HookCommand;
use ArtARTs36\GitHandler\Command\Commands\IgnoreCommand;
use ArtARTs36\GitHandler\Command\Commands\InitCommand;
use ArtARTs36\GitHandler\Command\Commands\LogCommand;
use ArtARTs36\GitHandler\Command\Commands\PathCommand;
use ArtARTs36\GitHandler\Command\Commands\PullCommand;
use ArtARTs36\GitHandler\Command\Commands\PushCommand;
use ArtARTs36\GitHandler\Command\Commands\RemoteCommand;
use ArtARTs36\GitHandler\Command\Commands\StashCommand;
use ArtARTs36\GitHandler\Command\Commands\StatusCommand;
use ArtARTs36\GitHandler\Command\Commands\TagCommand;
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
use ArtARTs36\GitHandler\Command\Commands\Contracts\GitArchiveCommand;

class Git implements GitHandler
{
    protected $commandBuilder;

    protected $executor;

    protected $fileSystem;

    protected $context;

    /**
     * @codeCoverageIgnore
     */
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

    /**
     * @codeCoverageIgnore
     */
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

    public function archives(): GitArchiveCommand
    {
        return new ArchiveCommand($this->commandBuilder, $this->executor);
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

    public function clones(): GitCloneCommand
    {
        return new CloneCommand($this->fileSystem, $this->context, $this->commandBuilder, $this->executor);
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

    /**
     * Delete local repository and fetch from origin
     */
    public function reinstall(?string $branch = null): void
    {
        $remote = $this->remotes()->showRemote()->fetch;

        $this->delete();

        $this->clones()->clone($remote, $branch);
    }

    public function delete(): bool
    {
        return $this->fileSystem->removeDir($this->context->getRootDir());
    }

    public function pulls(): GitPullCommand
    {
        return new PullCommand($this->commandBuilder, $this->executor);
    }

    public function files(): GitFileCommand
    {
        return new FileCommand($this->fileSystem, $this->context);
    }
}
