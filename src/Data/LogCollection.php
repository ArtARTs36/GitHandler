<?php

namespace ArtARTs36\GitHandler\Data;

use JetBrains\PhpStorm\Immutable;

/**
 * @template-implements \IteratorAggregate<int, Log>
 */
#[Immutable]
class LogCollection implements \IteratorAggregate, \Countable
{
    protected $logs;

    /**
     * @param non-empty-array<Log> $logs
     */
    public function __construct(array $logs)
    {
        $this->logs = $logs;
    }

    /**
     * Get first Log from collection.
     */
    public function first(): Log
    {
        return $this->logs[array_key_first($this->logs)];
    }

    /**
     * Get last Log from collection.
     */
    public function last(): Log
    {
        $logs = $this->logs;

        return end($logs);
    }

    public function filterByAuthorName(string $name): ?self
    {
        return $this->filter(function (Log $log) use ($name) {
            return $log->author->name === $name;
        });
    }

    public function filterByDate(\DateTimeInterface $date): ?self
    {
        return $this->filter(function (Log $log) use ($date) {
            return $log->equalsDate($date);
        });
    }

    public function filter(\Closure $callback): ?self
    {
        $logs = array_filter($this->logs, $callback);

        if (count($logs) === 0) {
            return null;
        }

        return new self(array_values($logs));
    }

    /**
     * @return iterable<Log>
     */
    public function getIterator(): iterable
    {
        return new \ArrayIterator($this->logs);
    }

    /**
     * Get count of logs.
     */
    public function count(): int
    {
        return count($this->logs);
    }

    /**
     * @return Log[]
     */
    public function all(): array
    {
        return $this->logs;
    }

    /**
     * @param array<string, string> $aliases - emails
     * @return array<string, CommitsAuthor>
     */
    public function getAuthorsWithCommits(array $aliases = []): array
    {
        $authors = [];

        foreach ($this->logs as $log) {
            $identity = $aliases[$log->author->email] ?? $log->author->email;

            if (! array_key_exists($identity, $authors)) {
                $authors[$identity]['author'] = $log->author;
                $authors[$identity]['commits'] = [];
            }

            $authors[$identity]['commits'][] = $log->commit;
        }

        return array_map([CommitsAuthor::class, 'fromArray'], $authors);
    }
}
