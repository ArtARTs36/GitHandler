<?php

namespace ArtARTs36\GitHandler\Config\Configurators;

use ArtARTs36\GitHandler\Config\Subjects\ConfigDiff;
use ArtARTs36\GitHandler\Contracts\Config\ConfigSubject;
use ArtARTs36\GitHandler\Contracts\Config\SubjectConfigurator;
use ArtARTs36\GitHandler\Support\TypeCaster;

class DiffConfigurator implements SubjectConfigurator
{
    public function parse(array $raw): ConfigSubject
    {
        return new ConfigDiff(TypeCaster::string($raw, 'external'), TypeCaster::boolean($raw['renames']));
    }

    public function getPrefix(): string
    {
        return 'diff';
    }
}
