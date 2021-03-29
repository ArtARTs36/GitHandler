<?php

namespace ArtARTs36\GitHandler\Config\Configurators;

use ArtARTs36\GitHandler\Config\Subjects\Core;
use ArtARTs36\GitHandler\Contracts\ConfigSubject;
use ArtARTs36\GitHandler\Contracts\SubjectConfigurator;

class CoreConfigurator implements SubjectConfigurator
{
    public function parse(array $raw): ConfigSubject
    {
        return new Core($raw['autocrlf'] ?? '');
    }

    public function getPrefix(): string
    {
        return 'core';
    }
}
