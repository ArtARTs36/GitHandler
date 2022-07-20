<?php

namespace ArtARTs36\GitHandler\Config\Subjects;

use ArtARTs36\GitHandler\Contracts\Config\ConfigSubjectList;

class AliasList extends AbstractSubject implements ConfigSubjectList
{
    public $aliases;

    /**
     * @param array<string, Alias> $aliases
     */
    public function __construct(array $aliases)
    {
        $this->aliases = $aliases;
    }

    /**
     * @return iterable<string, Alias>
     */
    public function getIterator(): iterable
    {
        return new \ArrayIterator($this->aliases);
    }
}
