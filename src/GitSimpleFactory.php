<?php

namespace ArtARTs36\GitHandler;

use ArtARTs36\GitHandler\Config\Configurators\BranchConfigurator;
use ArtARTs36\GitHandler\Config\RegexConfigResultParser;
use ArtARTs36\GitHandler\Config\Configurators\CoreConfigurator;
use ArtARTs36\GitHandler\Config\Configurators\CredentialConfigurator;
use ArtARTs36\GitHandler\Config\Configurators\PackConfigurator;
use ArtARTs36\GitHandler\Config\Configurators\UserConfigurator;
use ArtARTs36\GitHandler\Config\ConfiguratorsDict;
use ArtARTs36\GitHandler\Contracts\ConfigResultParser;
use ArtARTs36\GitHandler\Contracts\FileSystem;
use ArtARTs36\GitHandler\Contracts\GitHandler;
use ArtARTs36\GitHandler\Origin\Url\BitbucketOriginUrl;
use ArtARTs36\GitHandler\Origin\Url\GithubOriginUrl;
use ArtARTs36\GitHandler\Origin\Url\GitlabOriginUrl;
use ArtARTs36\GitHandler\Origin\Url\OriginUrlSelector;
use ArtARTs36\GitHandler\Support\LocalFileSystem;
use ArtARTs36\GitHandler\Support\SimpleHttpClient;
use ArtARTs36\ShellCommand\Executors\ProcOpenExecutor;
use ArtARTs36\ShellCommand\ShellCommander;

/**
 * @codeCoverageIgnore
 */
class GitSimpleFactory
{
    public static function factory(string $dir, ?FileSystem $fileSystem = null, string $executor = 'git'): GitHandler
    {
        return new Git(
            $dir,
            new Logger(),
            static::factoryConfigReader(),
            $fileSystem ?? new LocalFileSystem(),
            new ProcOpenExecutor(),
            new ShellCommander(),
            $executor
        );
    }

    public static function factoryConfigReader(?array $configurators = null): ConfigResultParser
    {
        return new RegexConfigResultParser(
            ConfiguratorsDict::make($configurators ?? [
                new UserConfigurator(),
                new CoreConfigurator(),
                new PackConfigurator(),
                new CredentialConfigurator(),
                new BranchConfigurator(),
            ])
        );
    }

    public static function factoryRepositoryDownloader(): RepositoryDownloader
    {
        return new RepositoryDownloader(
            static::factoryOriginUrlSelector(),
            new SimpleHttpClient(),
            new LocalFileSystem()
        );
    }

    public static function factoryOriginUrlSelector(): OriginUrlSelector
    {
        return OriginUrlSelector::make([
            new GithubOriginUrl(),
            new GitlabOriginUrl(),
            new BitbucketOriginUrl(),
        ]);
    }

    public static function factoryRepository(GitHandler $git): Repository
    {
        return new Repository($git, new LocalFileSystem());
    }
}
