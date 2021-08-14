<?php

namespace ArtARTs36\GitHandler\Command\Groups\Contracts;

use ArtARTs36\GitHandler\Data\Stash;

interface GitStashCommand
{
    /**
     * equals: git stash
     * equals: git stash save $message
     */
    public function stash(?string $message = null): bool;

    /**
     * equals: git stash pop
     */
    public function unStash(): bool;

    /**
     * @return array<Stash>
     */
    public function getStashList(): array;

    public function applyStash(int $id): bool;
}
