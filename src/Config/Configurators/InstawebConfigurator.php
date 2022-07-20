<?php

namespace ArtARTs36\GitHandler\Config\Configurators;

use ArtARTs36\GitHandler\Config\Subjects\Instaweb;
use ArtARTs36\GitHandler\Contracts\Config\ConfigSubject;
use ArtARTs36\GitHandler\Contracts\Config\SubjectConfigurator;
use ArtARTs36\GitHandler\Support\TypeCaster;

class InstawebConfigurator implements SubjectConfigurator
{
    public function parse(array $raw): ConfigSubject
    {
        return new Instaweb(
            TypeCaster::boolean($raw['local'] ?? ''),
            $raw['httpd'] ?? '',
            TypeCaster::integer($raw, 'port'),
            $raw['browser'] ?? '',
            $raw['modulePath'] ?? ''
        );
    }

    /**
     * @codeCoverageIgnore
     */
    public function getPrefix(): string
    {
        return 'instaweb';
    }
}
