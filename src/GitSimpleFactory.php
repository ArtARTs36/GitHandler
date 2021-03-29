<?php

namespace ArtARTs36\GitHandler;

use ArtARTs36\GitHandler\Config\ConfigReader;
use ArtARTs36\GitHandler\Config\Configurators\CoreConfigurator;
use ArtARTs36\GitHandler\Config\Configurators\PackConfigurator;
use ArtARTs36\GitHandler\Config\Configurators\UserConfigurator;
use ArtARTs36\GitHandler\Config\ConfiguratorsDict;
use ArtARTs36\GitHandler\Contracts\GitHandler;

class GitSimpleFactory
{
    public static function factory(string $dir, string $executor = 'git'): GitHandler
    {
        return new Git(
            $dir,
            new Logger(),
            static::factoryConfigReader(),
            $executor,
        );
    }

    public static function factoryConfigReader(): ConfigReader
    {
        return new ConfigReader(
            ConfiguratorsDict::make([
                new UserConfigurator(),
                new CoreConfigurator(),
                new PackConfigurator(),
            ])
        );
    }
}
