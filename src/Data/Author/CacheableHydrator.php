<?php

namespace ArtARTs36\GitHandler\Data\Author;

use ArtARTs36\GitHandler\Contracts\AuthorHydrator;
use ArtARTs36\GitHandler\Data\Author;

class CacheableHydrator implements AuthorHydrator
{
    protected $hydrator;

    /** @var array<string, Author> */
    protected $authors = [];

    public function __construct(AuthorHydrator $hydrator)
    {
        $this->hydrator = $hydrator;
    }

    public function hydrate(array $raw): Author
    {
        if (! array_key_exists($raw['email'], $this->authors)) {
            $this->authors[$raw['email']] = $this->hydrator->hydrate($raw);
        }

        return $this->authors[$raw['email']];
    }
}
