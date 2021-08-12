<?php

namespace ArtARTs36\GitHandler\Contracts;

use ArtARTs36\GitHandler\Data\Tag;
use ArtARTs36\GitHandler\Exceptions\TagAlreadyExists;

interface Taggable
{
    public function getTags(?string $pattern = null): array;

    /**
     * @throws TagAlreadyExists
     */
    public function performTag(string $tag, ?string $message = null): bool;

    public function isTagExists(string $tag): bool;

    public function getTag(string $name): Tag;
}
