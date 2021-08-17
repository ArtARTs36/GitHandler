<?php

namespace ArtARTs36\GitHandler\Command\Commands\Contracts;

use ArtARTs36\GitHandler\Exceptions\RepositoryAlreadyExists;

/**
 * Git Init
 */
interface GitInitCommand
{
    /**
     * Init git repository
     * @git-command git init
     * @throws RepositoryAlreadyExists
     */
    public function init(): bool;

    /**
     * Check for init repository
     */
    public function isInit(): bool;
}
