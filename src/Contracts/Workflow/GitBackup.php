<?php

namespace ArtARTs36\GitHandler\Contracts\Workflow;

/**
 * Git Backup (dump and restore git features)
 */
interface GitBackup
{
    /**
     * Dump workflow
     */
    public function dump(string $path): void;

    /**
     * Dump workflow
     * @param non-empty-list<class-string<BackupElement>|string> $elements
     */
    public function dumpOnly(string $path, array $elements): void;

    /**
     * Restore workflow
     */
    public function restore(string $path): void;
}
