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
    public function __construct(string $commit, \DateTimeInterface $date, Author $author, string $message)
    {
        $this->commit = $commit;
        $this->author = $author;
        $this->date = $date;
        $this->message = $message;
    }

    public function getAbbreviatedCommitHash(): string
    {
        return mb_substr($this->commit, 0, 6);
    }

    public function equalsDate(\DateTimeInterface $date): bool
    {
        return $this->date->format('Y-m-d') === $date->format('Y-m-d');
    }
}
