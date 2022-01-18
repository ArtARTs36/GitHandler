<?php

namespace ArtARTs36\GitHandler\Contracts;

use ArtARTs36\GitHandler\Data\Author;
use JetBrains\PhpStorm\ArrayShape;

interface AuthorHydrator
{
    /**
     * Hydrate raw array to Author object.
     */
    public function hydrate(
        #[ArrayShape(['name' => 'string', 'email' => 'string'])]
        array $raw
    ): Author;
}
