<?php

namespace ArtARTs36\GitHandler\Contracts\Commands;

use ArtARTs36\GitHandler\Enum\GarbageCollectMode;

/**
 * Git Garbage Collector
 */
interface GitGarbageCommand
{
    /**
     * Collect garbage
     * @git-command git gc --$mode
     */
    public function collect(GarbageCollectMode $mode): bool;

    /**
     * Collect garbage on older date
     * @git-command git gc --$mode --prune=$date
     */
    public function collectOnDate(GarbageCollectMode $mode, \DateTimeInterface $date): bool;
}
