<?php

namespace ArtARTs36\GitHandler\Contracts;

use ArtARTs36\GitHandler\Exceptions\BranchHasNoUpstream;

interface Pushable
{
    /**
     * @return bool
     * @throws BranchHasNoUpstream
     */
    public function push(bool $force = false): bool;
}
