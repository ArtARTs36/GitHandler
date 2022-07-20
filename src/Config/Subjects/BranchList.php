<?php

namespace ArtARTs36\GitHandler\Config\Subjects;

use ArtARTs36\GitHandler\Contracts\Config\ConfigSubjectList;

class BranchList extends AbstractSubject implements ConfigSubjectList
{
    public $branches;

    /**
     * @param array<string, Branch> $branches
     * @codeCoverageIgnore
     */
    public function __construct(array $branches)
    {
        $this->branches = $branches;
    }

    public function get(string $name): ?Branch
    {
        return $this->branches[$name] ?? null;
    }

    /**
     * @return iterable<string, Branch>
     */
    public function getIterator(): iterable
    {
        return new \ArrayIterator($this->branches);
    }
}
