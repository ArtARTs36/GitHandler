<?php

namespace ArtARTs36\GitHandler\Contracts\Commands;

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

    /**
     * Get git log for file
     * @git-command git log $filename
     */
    public function logForFile(string $filename): ?LogCollection;

    /**
     * Get git log for file on lines
     * @git-command git log -L $startLine:$endLine $filename
     */
    public function logForFileOnLines(string $filename, int $startLine, int $endLine): ?LogCollection;
}
