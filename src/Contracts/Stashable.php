<?php

namespace ArtARTs36\GitHandler\Contracts;

use ArtARTs36\GitHandler\Data\Stash;

interface Stashable
{
    public function stash(?string $message = null): bool;

    public function unStash(): bool;

    /**
     * @return array<Stash>
     */
    public function getStashList(): array;

    public function applyStash(int $id): bool;
}
