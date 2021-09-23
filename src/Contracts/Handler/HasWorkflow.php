<?php

namespace ArtARTs36\GitHandler\Contracts\Handler;

use ArtARTs36\GitHandler\Contracts\Workflow\GitBackup;

interface HasWorkflow
{
    /**
     * Get git workflow manager
     */
    public function workflow(): GitBackup;
}
