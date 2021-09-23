<?php

namespace ArtARTs36\GitHandler\Contracts\Handler;

use ArtARTs36\GitHandler\Contracts\Backup\GitBackup;

interface HasBackup
{
    /**
     * Get git backup manager
     */
    public function backup(): GitBackup;
}
