<?php

namespace ArtARTs36\GitHandler\Config\Configurators;

use ArtARTs36\GitHandler\Config\Subjects\Pack;
use ArtARTs36\GitHandler\Contracts\ConfigSubject;
use ArtARTs36\GitHandler\Contracts\SubjectConfigurator;

class PackConfigurator implements SubjectConfigurator
{
    public function parse(array $raw): ConfigSubject
    {
        return new Pack(
            $raw['windowmemory'] ?? '',
            $raw['packsizelimit'] ?? '',
            $raw['threads'] ?? 0,
            $raw['deltacachesize'] ?? '',
            $raw['sizelimit'] ?? '',
            $raw['window'] ?? 0
        );
    }

    public function getPrefix(): string
    {
        return 'pack';
    }
}
