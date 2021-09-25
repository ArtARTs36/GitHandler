<?php

namespace ArtARTs36\GitHandler;

use ArtARTs36\GitHandler\Command\Commands\ArchiveCommand;
use ArtARTs36\GitHandler\Command\Commands\AttributeCommand;
use ArtARTs36\GitHandler\Command\Commands\GarbageCommand;
use ArtARTs36\GitHandler\Command\Commands\MergeCommand;
use ArtARTs36\GitHandler\Command\Commands\SubmoduleCommand;
use ArtARTs36\GitHandler\Command\GitCommandBuilder;
use ArtARTs36\GitHandler\Config\Configurators\AliasConfigurator;
use ArtARTs36\GitHandler\Config\Configurators\CommitConfigurator;
use ArtARTs36\GitHandler\Config\Configurators\SubmoduleConfigurator;
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
use ArtARTs36\GitHandler\Config\Configurators\BranchConfigurator;
use ArtARTs36\GitHandler\Config\Configurators\CoreConfigurator;
use ArtARTs36\GitHandler\Config\Configurators\CredentialConfigurator;
use ArtARTs36\GitHandler\Config\Configurators\PackConfigurator;
use ArtARTs36\GitHandler\Config\Configurators\UserConfigurator;
use ArtARTs36\GitHandler\Config\ConfiguratorsDict;
use ArtARTs36\GitHandler\Config\RegexConfigResultParser;
use ArtARTs36\FileSystem\Contracts\FileSystem;
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
use ArtARTs36\GitHandler\Backup\Elements\ConfigBackupElement;
use ArtARTs36\GitHandler\Backup\Elements\HookBackupElement;
use ArtARTs36\GitHandler\Backup\Backup;
use ArtARTs36\GitHandler\Backup\Elements\UntrackedFilesBackupElement;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandExecutor;
use ArtARTs36\Str\Str;
use ArtARTs36\GitHandler\Contracts\Commands\GitArchiveCommand;

class Git extends AbstractGit
{
    protected function createSubjectsConfigurators(): array
    {
        return [
            new UserConfigurator(),
            new CoreConfigurator(),
            new PackConfigurator(),
            new CredentialConfigurator(),
            new BranchConfigurator(),
            new SubmoduleConfigurator(),
            new CommitConfigurator(),
            new AliasConfigurator(),
        ];
    }

    protected function createBackupElements(): array
    {
        return [
            new ConfigBackupElement(),
            new HookBackupElement(),
            new UntrackedFilesBackupElement(),
        ];
    }

    protected function createPathGenerator(): PathGenerator
    {
        return new TemporaryPathGenerator($this->fileSystem);
    }
}
