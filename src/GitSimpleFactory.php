<?php

namespace ArtARTs36\GitHandler;

use ArtARTs36\GitHandler\Config\RegexConfigResultParser;
use ArtARTs36\GitHandler\Config\Configurators\CoreConfigurator;
use ArtARTs36\GitHandler\Config\Configurators\CredentialConfigurator;
use ArtARTs36\GitHandler\Config\Configurators\PackConfigurator;
use ArtARTs36\GitHandler\Config\Configurators\UserConfigurator;
use ArtARTs36\GitHandler\Config\ConfiguratorsDict;
use ArtARTs36\GitHandler\Contracts\GitHandler;
use ArtARTs36\GitHandler\Support\LocalFileSystem;

class GitSimpleFactory
{
    public static function factory(string $dir, string $executor = 'git'): GitHandler
    {
        return new Git(
            $dir,
            new Logger(),
            static::factoryConfigReader(),
            new LocalFileSystem(),
            $executor,
        );
    }

    public static function factoryConfigReader(): RegexConfigResultParser
    {
        return new RegexConfigResultParser(
            ConfiguratorsDict::make([
                new UserConfigurator(),
                new CoreConfigurator(),
                new PackConfigurator(),
                new CredentialConfigurator(),
            ])
        );
    }
}
