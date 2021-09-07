<?php

namespace ArtARTs36\GitHandler\Config\Configurators;

use ArtARTs36\GitHandler\Config\Subjects\ConfigSubmodule;
use ArtARTs36\GitHandler\Config\Subjects\ConfigSubmoduleList;
use ArtARTs36\GitHandler\Contracts\Config\ConfigSubject;
use ArtARTs36\GitHandler\Contracts\Config\SubjectConfigurator;
use ArtARTs36\GitHandler\Support\TypeCaster;

class SubmoduleConfigurator implements SubjectConfigurator
{
    public function parse(array $raw): ConfigSubject
    {
        $modules = [];
        $parts = array_chunk($raw, 2, true);

        foreach ($parts as $part) {
            $name = explode('.', array_key_first($part))[0];

            $modules[$name] = new ConfigSubmodule(
                $name,
                $part[$name . '.url'],
                TypeCaster::boolean($part[$name . '.active'] ?? 'false'),
            );
        }

        return new ConfigSubmoduleList($modules);
    }

    /**
     * @codeCoverageIgnore
     */
    public function getPrefix(): string
    {
        return 'submodule';
    }
}
