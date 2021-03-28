<?php

namespace ArtARTs36\GitHandler;

use ArtARTs36\GitHandler\Data\Author;
use ArtARTs36\GitHandler\Data\Log;
use ArtARTs36\GitHandler\Data\LogCollection;

class Logger
{
    protected $regex = '/\* (.*)\|(.*)\|(.*)\|(.*)\|(.*)/m';

    public function parse(string $raw): ?LogCollection
    {
        $logs = [];
        $matches = [];
        /** @var array<string, Author> $authors */
        $authors = [];

        preg_match_all($this->regex, $raw, $matches, PREG_SET_ORDER, 0);

        foreach ($matches as $match) {
            if (count($match) !== 6) {
                continue;
            }

            if (array_key_exists($match[3], $authors)) {
                $author = $authors[$match[3]];
            } else {
                $author = new Author($match[3], $match[4]);
                $authors[$author->name] = $author;
            }

            $logs[] = new Log(
                $match[1],
                new \DateTime($match[2]),
                $author,
                trim($match[5])
            );
        }

        if (count($logs) === 0) {
            return null;
        }

        return new LogCollection($logs);
    }
}
