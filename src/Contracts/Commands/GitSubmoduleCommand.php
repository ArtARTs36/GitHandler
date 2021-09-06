<?php

namespace ArtARTs36\GitHandler\Contracts\Commands;

use ArtARTs36\GitHandler\Data\Submodule;
use ArtARTs36\GitHandler\Exceptions\SubmoduleNotFound;

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
     * @throws SubmoduleNotFound
     */
    public function remove(string $name): void;

    /**
     * Determine is exists submodule
     */
    public function exists(string $name): bool;

    /**
     * Sync git submodule
     * @git-command git submodule sync $name
     */
    public function sync(string $name): void;

    public function syncDefinesFromConfig(): void;
}
