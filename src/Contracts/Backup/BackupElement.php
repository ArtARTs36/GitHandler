<?php

namespace ArtARTs36\GitHandler\Contracts\Backup;

use ArtARTs36\GitHandler\Contracts\Handler\GitHandler;

interface BackupElement
{
    /**
     * Dump
     */
    public function dump(GitHandler $git): array;

    /**
     * Restore dumped data from array
     */
    public function restore(GitHandler $git, array $data): void;

    /**
     * Get this backup element identifier
     */
    public function identity(): string;
}
