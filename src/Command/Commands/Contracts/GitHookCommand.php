<?php

namespace ArtARTs36\GitHandler\Command\Commands\Contracts;

use ArtARTs36\GitHandler\Data\Hook;
use ArtARTs36\GitHandler\Enum\HookName;

/**
 * Git Hooks
 */
interface GitHookCommand
{
    /**
     * Add git Hook
     * @see HookName for $name
     */
    public function add(HookName $name, string $script): bool;

    /**
     * Check exists Hook
     * @see HookName for $name
     */
    public function has(string $name): bool;

    /**
     * @see HookName for $name
     * @covers \ArtARTs36\GitHandler\Exceptions\HookNotExists
     */
    public function delete(string $name): bool;

    /**
     * @see HookName for $name
     * @throws \ArtARTs36\GitHandler\Exceptions\HookNotExists
     */
    public function get(string $name): Hook;

    /**
     * @return array<string, Hook>
     */
    public function getAll(bool $onlyWorked = true): array;

    /**
     * Get path to hooks storage
     */
    public function getHookPath(?string $name = null): string;
}
