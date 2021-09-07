<?php

namespace ArtARTs36\GitHandler\Contracts\Handler;

use ArtARTs36\GitHandler\Contracts\Workflow\GitWorkflow;

interface HasWorkflow
{
    /**
     * Get git workflow manager
     */
    public function workflow(): GitWorkflow;
}
