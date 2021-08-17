<?php

namespace ArtARTs36\GitHandler\Config\Configurators;

use ArtARTs36\GitHandler\Config\Subjects\Core;
use ArtARTs36\GitHandler\Contracts\Config\ConfigSubject;
use ArtARTs36\GitHandler\Contracts\SubjectConfigurator;
use ArtARTs36\GitHandler\Support\TypeCaster;

class CoreConfigurator implements SubjectConfigurator
{
    public function parse(array $raw): ConfigSubject
    {
        return new Core(
            $raw['autocrlf'] ?? '',
            TypeCaster::boolean($raw['ignorecase'] ?? ''),
            $raw['repositoryformatversion'] ?? 0,
            TypeCaster::boolean($raw['bare'] ?? ''),
            TypeCaster::boolean($raw['logallrefupdates'] ?? ''),
            TypeCaster::boolean($raw['precomposeunicode'] ?? ''),
            TypeCaster::boolean($raw['filemode'] ?? '')
        );
    }

    /**
     * @inheritDoc
     * @codeCoverageIgnore
     */
    public function getPrefix(): string
    {
        return 'core';
    }
}
