<?php

namespace ArtARTs36\GitHandler;

use ArtARTs36\GitHandler\Contracts\LogParser;
use ArtARTs36\GitHandler\Data\Author;
use ArtARTs36\GitHandler\Data\Log;
use ArtARTs36\GitHandler\Data\LogCollection;

class Logger implements LogParser
{
    protected $regex = '/\* (.*)\|(.*)\|(.*)\|(.*)\|(.*)/m';

    /** @var array<string, Author> $authors */
    protected $authors = [];

    public function parse(string $raw): ?LogCollection
    {
        $logs = [];
        $matches = [];

        preg_match_all($this->regex, $raw, $matches, PREG_SET_ORDER, 0);

        foreach ($matches as $match) {
            if (count($match) !== 6) {
                continue;
            }

            $logs[] = new Log(
                $match[1],
                new \DateTime($match[2]),
                $this->getOrCreateAuthor($match[3], $match[4]),
                trim($match[5])
            );
        }

        if (count($logs) === 0) {
            return null;
        }

        return new LogCollection($logs);
    }

    protected function hasAuthor(string $name): bool
    {
        return array_key_exists($name, $this->authors);
    }

    protected function getOrCreateAuthor(string $name, string $email): Author
    {
        if (! $this->hasAuthor($name)) {
            $this->authors[$name] = new Author($name, $email);
        }

        return $this->authors[$name];
    }
}
