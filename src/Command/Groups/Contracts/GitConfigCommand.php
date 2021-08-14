<?php

namespace ArtARTs36\GitHandler\Command\Groups\Contracts;

use ArtARTs36\GitHandler\Config\Subjects\SubjectsCollection;
use ArtARTs36\GitHandler\Contracts\ConfigSubject;
use ArtARTs36\GitHandler\Exceptions\ConfigDataNotFound;
use ArtARTs36\GitHandler\Exceptions\SubjectConfiguratorNotFound;

interface GitConfigCommand
{
    public function getConfigList(): SubjectsCollection;

    /**
     * @throws ConfigDataNotFound
     * @throws SubjectConfiguratorNotFound
     */
    public function getConfigSubject(string $prefix): ConfigSubject;

    public function setConfig(string $scope, string $field, string $value, bool $replaceAll = false): bool;
}
