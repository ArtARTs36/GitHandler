<?php

namespace ArtARTs36\GitHandler\Data\Author;

use ArtARTs36\GitHandler\Contracts\AuthorHydrator;
use ArtARTs36\GitHandler\Data\Author;

class Hydrator implements AuthorHydrator
{
    public function hydrate(array $raw): Author
    {
        return new Author($raw['name'], $raw['email']);
    }
}
