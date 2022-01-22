<?php

namespace ArtARTs36\GitHandler\Support;

use ArtARTs36\GitHandler\Contracts\AuthorHydrator;
use ArtARTs36\GitHandler\Contracts\LogParser;
use ArtARTs36\GitHandler\Data\Author;
use ArtARTs36\GitHandler\Data\Commit;
use ArtARTs36\GitHandler\Data\Log;
use ArtARTs36\GitHandler\Data\LogCollection;
use ArtARTs36\Str\Str;

class Logger implements LogParser
{
    protected $regex = '/\|log-entry\|(.*?)\|(.*?)\|(.*?)\|(.*?)\|(.*?)\|/m';

    protected $authorHydrator;

    public function __construct(AuthorHydrator $authorHydrator)
    {
        $this->authorHydrator = $authorHydrator;
    }

    public function parse(Str $raw): ?LogCollection
    {
        $logs = [];

        foreach ($raw->globalMatch($this->regex) as $match) {
            $logs[] = new Log(
                new Commit(trim($match[1])),
                new \DateTime($match[2]),
                $this->createAuthor($match),
                trim($match[5])
            );
        }

        if (count($logs) === 0) {
            return null;
        }

        return new LogCollection($logs);
    }

    /**
     * @param array<int, mixed> $raw
     */
    protected function createAuthor(array $raw): Author
    {
        return $this->authorHydrator->hydrate([
            'name' => $raw[3],
            'email' => $raw[4],
        ]);
    }
}
