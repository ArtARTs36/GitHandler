<?php

namespace ArtARTs36\GitHandler\Data;

use JetBrains\PhpStorm\Immutable;

#[Immutable]
class Log
{
    public $commit;

    public $author;

    public $date;

    public $message;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(Commit $commit, \DateTimeInterface $date, Author $author, string $message)
    {
        $this->commit = $commit;
        $this->author = $author;
        $this->date = $date;
        $this->message = $message;
    }

    public function getAbbreviatedCommitHash(): string
    {
        return $this->commit->getAbbreviatedHash();
    }

    public function equalsDate(\DateTimeInterface $date): bool
    {
        return $this->date->format('Y-m-d') === $date->format('Y-m-d');
    }
}
