<?php

namespace ArtARTs36\GitHandler\Contracts\Commands;

use ArtARTs36\GitHandler\Data\Remotes;
use ArtARTs36\GitHandler\Exceptions\RemoteAlreadyExists;
use ArtARTs36\GitHandler\Exceptions\RemoteNotFound;
use ArtARTs36\GitHandler\Exceptions\RemoteRepositoryNotFound;

/**
 * Git Remote (add, show, remove, ...)
 */
interface GitRemoteCommand
{
    /**
     * Git add remote
     * @git-command git remote add $shortName $url
     * @throws RemoteAlreadyExists
     */
    public function add(string $shortName, string $url): bool;

    /**
     * Git show remote
     * @git-command git remote -v
     * @throws RemoteRepositoryNotFound
     */
    public function show(): Remotes;

    /**
     * Remove git remote
     * @git-command git remote remove $shortName
     * @throws RemoteNotFound
     */
    public function remove(string $shortName): bool;

    /**
     * Has push or fetch remote url
     */
    public function hasAnyRemoteUrl(string $url): bool;
}
