<?php

namespace ArtARTs36\GitHandler\Data;

use Webmozart\Assert\Assert;

class LogCollection implements \IteratorAggregate, \Countable
{
    protected $logs;

    /**
     * @param array<Log> $logs
     */
    public function __construct(array $logs)
    {
        Assert::notEmpty($logs);

        $this->logs = $logs;
    }

    public function first(): Log
    {
        return $this->logs[array_key_first($this->logs)];
    }

    public function last(): Log
    {
        return end($this->logs);
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
}
