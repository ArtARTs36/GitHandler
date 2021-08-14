<?php

namespace ArtARTs36\GitHandler\Command\Groups\Contracts;

use ArtARTs36\Str\Str;

interface GitStatusCommand
{
    /**
     * equals: git status
     */
    public function status(bool $short = false): Str;

    public function hasChanges(): bool;

    /**
     * @return array<string>
     */
    public function getUntrackedFiles(): array;

    /**
     * @return array<string>
     */
    public function getModifiedFiles(): array;

    /**
     * @return array<string>
     */
    public function getAddedFiles(): array;
}
