<?php

namespace ArtARTs36\GitHandler;

use ArtARTs36\GitHandler\Contracts\LogParser;
use ArtARTs36\GitHandler\Data\Author;
use ArtARTs36\GitHandler\Data\Commit;
use ArtARTs36\GitHandler\Data\Log;
use ArtARTs36\GitHandler\Data\LogCollection;
use ArtARTs36\Str\Str;

class Logger implements LogParser
{
    protected $regex = '/\* (.*)\|(.*)\|(.*)\|(.*)\|(.*)/m';

    /** @var array<string, Author> $authors */
    protected $authors = [];

    public function parse(Str $raw): ?LogCollection
    {
        $logs = [];

        foreach ($raw->globalMatch($this->regex) as $match) {
            $logs[] = new Log(
                new Commit($match[1]),
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
