<?php

namespace ArtARTs36\GitHandler\Contracts\Commands;

use ArtARTs36\GitHandler\Data\GitAttributes;

/**
 * Git Attributes
 */
interface GitAttributeCommand extends FolderSwitchable
{
    /**
     * Add git attribute
     */
    public function add(string $pattern, array $attributes): void;

    /**
     * Find git attribute by pattern
     */
    public function find(string $pattern): ?GitAttributes;
}
