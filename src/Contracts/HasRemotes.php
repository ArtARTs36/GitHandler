<?php

namespace ArtARTs36\GitHandler\Contracts;

use ArtARTs36\GitHandler\Data\Remotes;
use ArtARTs36\GitHandler\Exceptions\RemoteAlreadyExists;
use ArtARTs36\GitHandler\Exceptions\RemoteNotFound;
use ArtARTs36\GitHandler\Exceptions\RemoteRepositoryNotFound;

interface HasRemotes
{
    /**
     * @throws RemoteAlreadyExists
     */
    public function addRemote(string $shortName, string $url): bool;

    /**
     * equals: git remote show origin
     * @throws RemoteRepositoryNotFound
     */
    public function showRemote(): Remotes;

    /**
     * @throws RemoteNotFound
     */
    public function removeRemote(string $shortName): bool;

    /**
     * Has push or fetch remote url
     */
    public function hasAnyRemoteUrl(string $url): bool;
}
