<?php

namespace ArtARTs36\GitHandler\Contracts\Commands;

use ArtARTs36\GitHandler\Data\Submodule;

/**
 * Git Submodule
 */
interface GitSubmoduleCommand
{
    /**
     * Add git submodule
     * @git-command git submodule add $url
     */
    public function add(string $url): void;

    /**
     * Get all submodules
     * @return array<string, Submodule>
     */
    public function getAll(): array;

    /**
     * Remove submodule
     */
    public function remove(string $name): void;

    /**
     * Determine is exists submodule
     */
    public function exists(string $name): bool;
}
