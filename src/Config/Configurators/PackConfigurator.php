<?php

namespace ArtARTs36\GitHandler\Config\Configurators;

use ArtARTs36\GitHandler\Config\Subjects\Pack;
use ArtARTs36\GitHandler\Contracts\Config\ConfigSubject;
use ArtARTs36\GitHandler\Contracts\Config\SubjectConfigurator;
use ArtARTs36\GitHandler\Support\TypeCaster;

class PackConfigurator implements SubjectConfigurator
{
    public function parse(array $raw): ConfigSubject
    {
        return new Pack(
            $raw['windowmemory'] ?? '',
            $raw['packsizelimit'] ?? '',
            TypeCaster::integer($raw, 'threads'),
            $raw['deltacachesize'] ?? '',
            $raw['sizelimit'] ?? '',
            TypeCaster::integer($raw, 'window')
        );
    }

    /**
     * @inheritDoc
     * @codeCoverageIgnore
     */
    public function getPrefix(): string
    {
        return 'pack';
    }
}
