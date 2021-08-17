<?php

namespace ArtARTs36\GitHandler\Command\Commands\Contracts;

use ArtARTs36\GitHandler\Exceptions\BranchHasNoUpstream;

/**
 * Git Push
 */
interface GitPushCommand
{
    /**
     * Push to remote git
     * @git-command git push
     * @git-command git push --force
     * @git-command git push --force set-upstream $upStream
     * @throws BranchHasNoUpstream
     */
    public function push(bool $force = false, ?string $upStream = null): bool;

    /**
     * Push to remote git through current-branch
     * @git-command git push --set-upstream origin {current-branch}
     */
    public function pushOnAutoSetUpStream(bool $force = false): bool;
}
