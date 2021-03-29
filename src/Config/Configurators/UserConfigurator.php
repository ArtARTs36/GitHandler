<?php

namespace ArtARTs36\GitHandler\Config\Configurators;

use ArtARTs36\GitHandler\Config\Subjects\User;
use ArtARTs36\GitHandler\Contracts\ConfigSubject;
use ArtARTs36\GitHandler\Contracts\SubjectConfigurator;

class UserConfigurator implements SubjectConfigurator
{
    public function parse(array $raw): ConfigSubject
    {
        return new User($raw['name'] ?? '', $raw['email'] ?? '');
    }

    public function getPrefix(): string
    {
        return 'user';
    }
}
