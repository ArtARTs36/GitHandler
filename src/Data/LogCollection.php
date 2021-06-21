<?php

namespace ArtARTs36\GitHandler\Data;

use JetBrains\PhpStorm\Immutable;
use Webmozart\Assert\Assert;

#[Immutable]
class LogCollection implements \IteratorAggregate, \Countable
{
    protected $logs;

    /**
     * @param array<Log> $logs
     * @throws \InvalidArgumentException
     */
    public function __construct(array $logs)
    {
        Assert::notEmpty($logs);
        Assert::allIsInstanceOf($logs, Log::class);

        $this->logs = $logs;
    }

    public function first(): Log
    {
        return $this->logs[array_key_first($this->logs)];
    }

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

        return new static($logs);
    }

    /**
     * @return \ArrayIterator|iterable<Log>
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->logs);
    }

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
}
