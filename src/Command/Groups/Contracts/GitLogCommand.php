<?php

namespace ArtARTs36\GitHandler\Command\Groups\Contracts;

use ArtARTs36\GitHandler\Data\LogCollection;

/**
 * Git Log
 */
interface GitLogCommand
{
    /**
     * Get all git logs
     * @git-command git log
     */
    public function getAll(): ?LogCollection;
}
