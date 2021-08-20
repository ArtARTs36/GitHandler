<?php

namespace ArtARTs36\GitHandler\Contracts\Commands;

use ArtARTs36\GitHandler\Enum\GarbageCollectMode;

/**
 * Collect garbage
 */
interface GitGarbageCommand
{
    /**
     * Collect garbage
     */
    public function collect(GarbageCollectMode $mode): void;

    /**
     * Collect garbage on older date
     */
    public function collectOnDate(GarbageCollectMode $mode, \DateTimeInterface $date): void;
}
