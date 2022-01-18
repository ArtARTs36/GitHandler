<?php

namespace ArtARTs36\GitHandler;

use ArtARTs36\GitHandler\Config\Configurators\AliasConfigurator;
use ArtARTs36\GitHandler\Config\Configurators\CommitConfigurator;
use ArtARTs36\GitHandler\Config\Configurators\DiffConfigurator;
use ArtARTs36\GitHandler\Config\Configurators\InstawebConfigurator;
use ArtARTs36\GitHandler\Config\Configurators\SubmoduleConfigurator;
use ArtARTs36\GitHandler\Config\Configurators\BranchConfigurator;
use ArtARTs36\GitHandler\Config\Configurators\CoreConfigurator;
use ArtARTs36\GitHandler\Config\Configurators\CredentialConfigurator;
use ArtARTs36\GitHandler\Config\Configurators\PackConfigurator;
use ArtARTs36\GitHandler\Config\Configurators\UserConfigurator;
use ArtARTs36\GitHandler\Contracts\LogParser;
use ArtARTs36\GitHandler\Contracts\PathGenerator;
use ArtARTs36\GitHandler\Data\Author\CacheableHydrator;
use ArtARTs36\GitHandler\Data\Author\Hydrator;
use ArtARTs36\GitHandler\Support\Logger;
use ArtARTs36\GitHandler\Support\TemporaryPathGenerator;
use ArtARTs36\GitHandler\Backup\Elements\ConfigBackupElement;
use ArtARTs36\GitHandler\Backup\Elements\HookBackupElement;
use ArtARTs36\GitHandler\Backup\Elements\UntrackedFilesBackupElement;

class Git extends AbstractGit
{
    protected function createSubjectsConfigurators(): iterable
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
            new InstawebConfigurator(),
            new DiffConfigurator(),
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

    protected function createLogParser(): LogParser
    {
        return new Logger(new CacheableHydrator(new Hydrator()));
    }
}
