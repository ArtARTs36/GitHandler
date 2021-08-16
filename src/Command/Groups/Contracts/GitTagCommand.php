<?php

namespace ArtARTs36\GitHandler\Command\Groups\Contracts;

use ArtARTs36\GitHandler\Data\Tag;
use ArtARTs36\GitHandler\Exceptions\TagAlreadyExists;
use ArtARTs36\GitHandler\Exceptions\TagNotFound;

/**
 * Git Tags
 */
interface GitTagCommand
{
    /**
     * Get all git tags
     * @git-command git tag
     * @git-command git tag -l=$pattern
     * @return array<string>
     */
    public function getAll(?string $pattern = null): array;

    /**
     * Add git tag
     * @git-command git -a $tag
     * @git-command git -a $tag -m $message
     * @throws TagAlreadyExists
     */
    public function add(string $tag, ?string $message = null): bool;

    /**
     * Check tag exists
     */
    public function exists(string $tag): bool;

    /**
     * Get git tag information
     * @git-command git show $tagName
     * @throws TagNotFound
     */
    public function get(string $tagName): Tag;
}
