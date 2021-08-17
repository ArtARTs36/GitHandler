<?php

namespace ArtARTs36\GitHandler\Command\Commands\Contracts;

/**
 * Git fetch (git fetch, git fetch --all, ...)
 */
interface GitFetchCommand
{
    /**
     * Git fetch
     * @git-command git fetch
     */
    public function fetch(): void;

    /**
     * Git fetch all
     * @git-command git fetch --all
     */
    public function fetchAll(): void;
}
