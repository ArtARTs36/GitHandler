<?php

namespace ArtARTs36\GitHandler\Command\Groups\Contracts;

use ArtARTs36\Str\Str;

/**
 * Git Status
 */
interface GitStatusCommand
{
    /**
     * Get git status
     * @git-command git status
     */
    public function status(bool $short = false): Str;

    /**
     * Check has changes
     */
    public function hasChanges(): bool;

    /**
     * Get untracked files
     * @return array<string>
     */
    public function getUntrackedFiles(): array;

    /**
     * Get modified files
     * @return array<string>
     */
    public function getModifiedFiles(): array;

    /**
     * Get added files
     * @return array<string>
     */
    public function getAddedFiles(): array;
}
