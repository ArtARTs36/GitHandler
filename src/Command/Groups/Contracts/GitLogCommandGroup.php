<?php

namespace ArtARTs36\GitHandler\Command\Groups\Contracts;

use ArtARTs36\GitHandler\Data\LogCollection;

interface GitLogCommandGroup
{
    /**
     * Get all git logs
     * equals: git log
     */
    public function getAll(): ?LogCollection;
}
