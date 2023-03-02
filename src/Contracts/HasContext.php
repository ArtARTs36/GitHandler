<?php

namespace ArtARTs36\GitHandler\Contracts;

use ArtARTs36\GitHandler\Data\GitContext;

interface HasContext
{
    /**
     * Get context.
     */
    public function getContext(): GitContext;
}
