<?php

namespace ArtARTs36\GitHandler\Contracts\Backup;

use ArtARTs36\GitHandler\Contracts\Handler\GitHandler;

interface BackupElement
{
    /**
     * Dump
     * @return array<mixed>
     */
    public function dump(GitHandler $git): array;

    /**
     * Restore dumped data from array
     * @param array<mixed> $data
     */
    public function restore(GitHandler $git, array $data): void;

    /**
     * Get this backup element identifier
     */
    public function identity(): string;
}
