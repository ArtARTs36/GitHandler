<?php

namespace ArtARTs36\GitHandler\Contracts;

interface Configurable
{
    /**
     * @return array<ConfigSubject>
     */
    public function getConfigList(): array;

    public function setConfig(string $scope, string $field, string $value): bool;
}
