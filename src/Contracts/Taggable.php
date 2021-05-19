<?php

namespace ArtARTs36\GitHandler\Contracts;

use ArtARTs36\GitHandler\Exceptions\TagAlreadyExists;
use ArtARTs36\Str\StrCollection;

interface Taggable
{
    public function getTags(?string $pattern = null): StrCollection;

    /**
     * @throws TagAlreadyExists
     */
    public function performTag(string $tag, ?string $message = null): bool;

    public function isTagExists(string $tag): bool;
}
