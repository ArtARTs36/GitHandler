<?php

namespace ArtARTs36\GitHandler\Command\Commands\Contracts;

use ArtARTs36\GitHandler\Exceptions\RepositoryAlreadyExists;

/**
 * Git Init
 */
interface GitSetupCommand
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

    /**
     * Git Clone
     * @git-command git clone $url
     * @git-command git clone $url -b $branch
     */
    public function clone(string $url, ?string $branch = null, ?string $folder = null): bool;
}
