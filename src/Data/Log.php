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

    public function __construct(Commit $commit, \DateTimeInterface $date, Author $author, string $message)
    {
        $this->commit = $commit;
        $this->author = $author;
        $this->date = $date;
        $this->message = $message;
    }

    public function equalsDate(\DateTimeInterface $date): bool
    {
        return $this->date->format('Y-m-d') === $date->format('Y-m-d');
    }
}
