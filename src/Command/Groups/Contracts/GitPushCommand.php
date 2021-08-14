<?php

namespace ArtARTs36\GitHandler\Command\Groups\Contracts;

use ArtARTs36\GitHandler\Exceptions\BranchHasNoUpstream;

interface GitPushCommand
{
    /**
     * @return bool
     * @throws BranchHasNoUpstream
     */
    public function push(bool $force = false, ?string $upStream = null): bool;

    /**
     * equals: git push --set-upstream origin {current-branch}
     */
    public function pushOnAutoSetUpStream(bool $force = false): bool;
}
