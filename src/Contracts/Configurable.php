<?php

namespace ArtARTs36\GitHandler\Contracts;

use ArtARTs36\GitHandler\Config\Subjects\SubjectsCollection;
use ArtARTs36\GitHandler\Exceptions\SubjectConfiguratorNotFound;

interface Configurable
{
    public function getConfigList(): SubjectsCollection;

    /**
     * @throws SubjectConfiguratorNotFound
     */
    public function getConfigSubject(string $prefix): ConfigSubject;

    public function setConfig(string $scope, string $field, string $value, bool $replaceAll = false): bool;
}
