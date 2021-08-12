<?php

namespace ArtARTs36\GitHandler\Command\Groups\Contracts;

use ArtARTs36\GitHandler\Data\Tag;
use ArtARTs36\GitHandler\Exceptions\TagAlreadyExists;
use ArtARTs36\GitHandler\Exceptions\TagNotFound;

interface GitTagCommandGroup
{
    /**
     * @return array<string>
     */
    public function getAll(?string $pattern = null): array;

    /**
     * @throws TagAlreadyExists
     */
    public function add(string $tag, ?string $message = null): bool;

    public function exists(string $tag): bool;

    /**
     * @throws TagNotFound
     */
    public function get(string $name): Tag;
}
