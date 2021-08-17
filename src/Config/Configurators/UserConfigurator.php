<?php

namespace ArtARTs36\GitHandler\Config\Configurators;

use ArtARTs36\GitHandler\Config\Subjects\User;
use ArtARTs36\GitHandler\Contracts\Config\ConfigSubject;
use ArtARTs36\GitHandler\Contracts\Config\SubjectConfigurator;

class UserConfigurator implements SubjectConfigurator
{
    /**
     * @param array<string, string> $raw
     * @return User
     */
    public function parse(array $raw): ConfigSubject
    {
        return new User($raw['name'] ?? '', $raw['email'] ?? '');
    }

    /**
     * @inheritDoc
     * @codeCoverageIgnore
     */
    public function getPrefix(): string
    {
        return 'user';
    }
}
