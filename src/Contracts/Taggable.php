<?php

namespace ArtARTs36\GitHandler\Contracts;

use ArtARTs36\GitHandler\Exceptions\TagAlreadyExist;

interface Taggable
{
    public function getTags(?string $pattern = null): array;

    /**
     * @throws TagAlreadyExist
     */
    public function performTag(string $tag, ?string $message = null): bool;

    public function isTagExists(string $tag): bool;
}
