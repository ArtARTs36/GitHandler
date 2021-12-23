<?php

namespace ArtARTs36\GitHandler\Config\Subjects;

use ArtARTs36\GitHandler\Contracts\Config\ConfigSubject;

class SubjectsCollection implements \IteratorAggregate, \Countable
{
    protected $subjects;

    /**
     * @param array<ConfigSubject> $subjects
     * @codeCoverageIgnore
     */
    public function __construct(array $subjects)
    {
        $this->subjects = $subjects;
    }

    public function count(): int
    {
        return count($this->subjects);
    }

    /**
     * @return iterable<ConfigSubject>
     */
    public function getIterator(): iterable
    {
        return new \ArrayIterator($this->subjects);
    }

    /**
     * @return ConfigSubject[]
     */
    public function all(): array
    {
        return $this->subjects;
    }

    /**
     * @return array<string, array<string, string>>
     */
    public function toArray(): array
    {
        $array = [];

        foreach ($this->subjects as $subject) {
            $array[$subject->name()] = $subject->toArray();
        }

        return $array;
    }
}
