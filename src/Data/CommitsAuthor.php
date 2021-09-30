<?php

namespace ArtARTs36\GitHandler\Data;

use ArtARTs36\GitHandler\Support\ToArray;
use JetBrains\PhpStorm\ArrayShape;

class CommitsAuthor implements \IteratorAggregate, \Countable
{
    use ToArray;

    public $author;

    public $commits;

    /**
     * @param array<Commit> $commits
     */
    public function __construct(Author $author, array $commits)
    {
        $this->author = $author;
        $this->commits = $commits;
    }

    /**
     * @param array<string, Author|array<Commit>> $data
     */
    public static function fromArray(
        #[ArrayShape(['author' => Author::class, 'commits' => 'array'])]
        array $data
    ): self {
        return new self($data['author'], $data['commits']);
    }

    public function count(): int
    {
        return count($this->commits);
    }

    /**
     * @return iterable<Commit>
     */
    public function getIterator(): iterable
    {
        return new \ArrayIterator($this->commits);
    }
}
