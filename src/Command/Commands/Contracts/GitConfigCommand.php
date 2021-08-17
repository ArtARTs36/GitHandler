<?php

namespace ArtARTs36\GitHandler\Command\Commands\Contracts;

use ArtARTs36\GitHandler\Config\Subjects\SubjectsCollection;
use ArtARTs36\GitHandler\Contracts\Config\ConfigSubject;
use ArtARTs36\GitHandler\Exceptions\ConfigDataNotFound;
use ArtARTs36\GitHandler\Exceptions\SubjectConfiguratorNotFound;

/**
 * Git Config (set, get list, ...)
 */
interface GitConfigCommand
{
    /**
     * Get config list
     * @git-command git config --list
     */
    public function getConfigList(): SubjectsCollection;

    /**
     * Get config subject
     * @git-command git config --list
     * @throws ConfigDataNotFound
     * @throws SubjectConfiguratorNotFound
     */
    public function getConfigSubject(string $prefix): ConfigSubject;

    /**
     * Set git config
     * @git-command git config $scope.$field=$value
     * @git-command git config $scope.$field=$value --replace-all
     */
    public function setConfig(string $scope, string $field, string $value, bool $replaceAll = false): bool;
}
