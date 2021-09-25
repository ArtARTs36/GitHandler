<?php

namespace ArtARTs36\GitHandler;

use ArtARTs36\GitHandler\Command\Commands\ArchiveCommand;
use ArtARTs36\GitHandler\Command\Commands\AttributeCommand;
use ArtARTs36\GitHandler\Command\Commands\GarbageCommand;
use ArtARTs36\GitHandler\Command\Commands\MergeCommand;
use ArtARTs36\GitHandler\Command\Commands\SubmoduleCommand;
use ArtARTs36\GitHandler\Command\GitCommandBuilder;
use ArtARTs36\GitHandler\Contracts\Backup\BackupElement;
use ArtARTs36\GitHandler\Contracts\Commands\GitAttributeCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitFileCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitGarbageCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitMergeCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitPullCommand;
use ArtARTs36\GitHandler\Command\Commands\FileCommand;
use ArtARTs36\GitHandler\Command\Commands\IndexCommand;
use ArtARTs36\GitHandler\Command\Commands\BranchCommand;
use ArtARTs36\GitHandler\Command\Commands\CommitCommand;
use ArtARTs36\GitHandler\Command\Commands\ConfigCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitIndexCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitBranchCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitCommitCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitConfigCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitGrepCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitHelpCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitHookCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitIgnoreCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitSetupCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitLogCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitPathCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitPushCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitRemoteCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitStashCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitStatusCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitSubmoduleCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitTagCommand;
use ArtARTs36\GitHandler\Command\Commands\GrepCommand;
use ArtARTs36\GitHandler\Command\Commands\HelpCommand;
use ArtARTs36\GitHandler\Command\Commands\HookCommand;
use ArtARTs36\GitHandler\Command\Commands\IgnoreCommand;
use ArtARTs36\GitHandler\Command\Commands\SetupCommand;
use ArtARTs36\GitHandler\Command\Commands\LogCommand;
use ArtARTs36\GitHandler\Command\Commands\PathCommand;
use ArtARTs36\GitHandler\Command\Commands\PullCommand;
use ArtARTs36\GitHandler\Command\Commands\PushCommand;
use ArtARTs36\GitHandler\Command\Commands\RemoteCommand;
use ArtARTs36\GitHandler\Command\Commands\StashCommand;
use ArtARTs36\GitHandler\Command\Commands\StatusCommand;
use ArtARTs36\GitHandler\Command\Commands\TagCommand;
use ArtARTs36\GitHandler\Config\ConfiguratorsDict;
use ArtARTs36\GitHandler\Config\RegexConfigResultParser;
use ArtARTs36\FileSystem\Contracts\FileSystem;
use ArtARTs36\GitHandler\Contracts\Config\SubjectConfigurator;
use ArtARTs36\GitHandler\Contracts\Handler\GitHandler;
use ArtARTs36\GitHandler\Contracts\PathGenerator;
use ArtARTs36\GitHandler\Contracts\Transaction\GitTransaction;
use ArtARTs36\GitHandler\Contracts\Backup\GitBackup;
use ArtARTs36\GitHandler\Data\GitContext;
use ArtARTs36\GitHandler\Data\Version;
use ArtARTs36\GitHandler\Support\Logger;
use ArtARTs36\GitHandler\Support\TemporaryPathGenerator;
use ArtARTs36\GitHandler\Transactions\ArchiveTransaction;
use ArtARTs36\GitHandler\Backup\ArrayBackupElementDict;
use ArtARTs36\GitHandler\Backup\Backup;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandExecutor;
use ArtARTs36\GitHandler\Contracts\Commands\GitArchiveCommand;

abstract class AbstractGit implements GitHandler
{
    /**
     * @return array<SubjectConfigurator>
     */
    abstract protected function createSubjectsConfigurators(): array;

    /**
     * @return array<BackupElement>
     */
    abstract protected function createBackupElements(): array;

    abstract protected function createPathGenerator(): PathGenerator;

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
        return new ArchiveCommand(
            $this->fileSystem,
            $this->context,
            $this->commandBuilder,
            $this->executor
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

    public function setup(): GitSetupCommand
    {
        return new SetupCommand(
            $this->remotes(),
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
                ConfiguratorsDict::make($this->createSubjectsConfigurators())
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
        return new IgnoreCommand($this->context, $this->fileSystem);
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

        return new Version($result, ...$result->match('/([0-9]+.[0-9]+.[0-9]+)/i')->sentences()->toIntegers());
    }

    public function pulls(): GitPullCommand
    {
        return new PullCommand($this->commandBuilder, $this->executor);
    }

    public function files(): GitFileCommand
    {
        return new FileCommand($this->fileSystem, $this->context);
    }

    public function transaction(): GitTransaction
    {
        return new ArchiveTransaction($this->context, $this, $this->fileSystem, $this->createPathGenerator());
    }

    public function garbage(): GitGarbageCommand
    {
        return new GarbageCommand($this->commandBuilder, $this->executor);
    }

    public function merges(): GitMergeCommand
    {
        return new MergeCommand($this->commandBuilder, $this->executor);
    }

    public function attributes(): GitAttributeCommand
    {
        return new AttributeCommand($this->fileSystem, $this->context);
    }

    public function submodules(): GitSubmoduleCommand
    {
        return new SubmoduleCommand(
            $this->config(),
            $this->index(),
            $this->context,
            $this->fileSystem,
            $this->commandBuilder,
            $this->executor
        );
    }

    public function backup(): GitBackup
    {
        return new Backup($this, $this->fileSystem, (new ArrayBackupElementDict($this->createBackupElements())));
    }
}
