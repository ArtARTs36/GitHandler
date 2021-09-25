<?php

namespace ArtARTs36\GitHandler\Config\Configurators;

use ArtARTs36\GitHandler\Config\Subjects\Alias;
use ArtARTs36\GitHandler\Config\Subjects\AliasList;
use ArtARTs36\GitHandler\Contracts\Config\ConfigSubject;
use ArtARTs36\GitHandler\Contracts\Config\SubjectConfigurator;

class AliasConfigurator implements SubjectConfigurator
{
    public function parse(array $raw): ConfigSubject
    {
        $aliases = [];

        foreach ($raw as $name => $script) {
            $aliases[$name] = new Alias($name, $script);
        }

        return new AliasList($aliases);
    }

    public function getPrefix(): string
    {
        return 'alias';
    }
}
