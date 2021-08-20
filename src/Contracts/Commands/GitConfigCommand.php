<?php

namespace ArtARTs36\GitHandler\Contracts\Commands;

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
    public function getAll(): SubjectsCollection;

    /**
     * Get config subject
     * @git-command git config --list
     * @throws ConfigDataNotFound
     * @throws SubjectConfiguratorNotFound
     */
    public function getSubject(string $prefix): ConfigSubject;

    /**
     * Set git config
     * @git-command git config $scope.$field=$value
     * @git-command git config $scope.$field=$value --replace-all
     */
    public function set(string $scope, string $field, string $value, bool $replaceAll = false): bool;
}
