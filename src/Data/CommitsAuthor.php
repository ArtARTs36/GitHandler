<?php

namespace ArtARTs36\GitHandler\Data;

use JetBrains\PhpStorm\ArrayShape;

class CommitsAuthor
{
    public $author;

    public $commits;

    public function __construct(Author $author, int $commits)
    {
        $this->author = $author;
        $this->commits = $commits;
    }

    /**
     * @param array<string, Author|int> $data
     */
    public static function fromArray(
        #[ArrayShape(['author' => Author::class, 'commits' => 'int'])]
        array $data
    ): self {
        return new self($data['author'], $data['commits']);
    }
}
