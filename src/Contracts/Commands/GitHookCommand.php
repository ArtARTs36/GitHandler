<?php

namespace ArtARTs36\GitHandler\Contracts\Commands;

use ArtARTs36\GitHandler\Data\Hook;
use ArtARTs36\GitHandler\Enum\HookName;

/**
 * Git Hooks
 */
interface GitHookCommand
{
    /**
     * Add git Hook
     */
    public function add(HookName $name, string $script): bool;

    /**
     * Check exists Hook
     */
    public function has(HookName $name): bool;

    /**
     * @covers \ArtARTs36\GitHandler\Exceptions\HookNotExists
     */
    public function delete(HookName $name): bool;

    /**
     * @throws \ArtARTs36\GitHandler\Exceptions\HookNotExists
     */
    public function get(HookName $name): Hook;

    /**
     * @return array<string, Hook>
     */
    public function getAll(bool $onlyWorked = true): array;

    /**
     * Get path to hooks storage
     */
    public function getHookPath(?string $name = null): string;
}
