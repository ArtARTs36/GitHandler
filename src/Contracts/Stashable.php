<?php

namespace ArtARTs36\GitHandler\Contracts;

interface Stashable
{
    public function stash(?string $message = null): bool;

    public function unStash(): bool;
}
