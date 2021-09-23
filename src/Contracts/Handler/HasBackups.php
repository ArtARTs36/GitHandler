<?php

namespace ArtARTs36\GitHandler\Contracts\Handler;

use ArtARTs36\GitHandler\Contracts\Backup\GitBackup;

interface HasBackups
{
    /**
     * Get git backup manager
     */
    public function backups(): GitBackup;
}
