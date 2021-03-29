<?php

namespace ArtARTs36\GitHandler\Contracts;

use ArtARTs36\GitHandler\Exceptions\SubjectConfiguratorNotFound;

interface Configurable
{
    /**
     * @return array<ConfigSubject>
     */
    public function getConfigList(): array;

    /**
     * @throws SubjectConfiguratorNotFound
     */
    public function getConfigSubject(string $prefix): ConfigSubject;

    public function setConfig(string $scope, string $field, string $value): bool;
}
