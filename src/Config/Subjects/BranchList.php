<?php

namespace ArtARTs36\GitHandler\Config\Subjects;

class BranchList extends AbstractSubject
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
}
