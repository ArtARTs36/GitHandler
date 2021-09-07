<?php

namespace ArtARTs36\GitHandler\Config\Configurators;

use ArtARTs36\GitHandler\Config\Subjects\ConfigCommit;
use ArtARTs36\GitHandler\Contracts\Config\ConfigSubject;
use ArtARTs36\GitHandler\Contracts\Config\SubjectConfigurator;

class CommitConfigurator implements SubjectConfigurator
{
    public function parse(array $raw): ConfigSubject
    {
        return new ConfigCommit($raw['template'] ?? '');
    }

    public function getPrefix(): string
    {
        return 'commit';
    }
}
