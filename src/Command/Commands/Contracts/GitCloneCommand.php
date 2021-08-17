<?php

namespace ArtARTs36\GitHandler\Command\Commands\Contracts;

/**
 * Git Clone
 */
interface GitCloneCommand
{
    /**
     * @git-command git clone $url
     * @git-command git clone $url -b $branch
     */
    public function clone(string $url, ?string $branch = null, ?string $folder = null): bool;
}
