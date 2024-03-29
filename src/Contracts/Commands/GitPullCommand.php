<?php

namespace ArtARTs36\GitHandler\Contracts\Commands;

/**
 * Git Pull
 */
interface GitPullCommand
{
    /**
     * Pull changes from git remote
     * @git-command git pull
     */
    public function pull(): bool;

    /**
     * Pull changes from git remote
     * @git-command git pull $branch
     */
    public function pullBranch(string $branch): bool;
}
