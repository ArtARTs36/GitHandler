<?php

namespace ArtARTs36\GitHandler\Contracts\Backup;

/**
 * Git Backup (dump and restore git features)
 */
interface GitBackup
{
    /**
     * Dump backup
     */
    public function dump(string $path): void;

    /**
     * Dump backup
     * @param non-empty-list<class-string<BackupElement>|string> $elements
     */
    public function dumpOnly(string $path, array $elements): void;

    /**
     * Restore backup
     */
    public function restore(string $path): void;

    /**
     * Restore backup
     * @param non-empty-list<class-string<BackupElement>|string> $elements
     */
    public function restoreOnly(string $path, array $elements): void;
}
