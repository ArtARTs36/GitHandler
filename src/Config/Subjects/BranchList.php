<?php

namespace ArtARTs36\GitHandler\Config\Subjects;

class BranchList extends AbstractSubject
{
    public $branches;

    /**
     * @param array<string, Branch> $branches
     */
    public function __construct(array $branches)
    {
        $this->branches = $branches;
    }

    public function getBranch(string $name): ?Branch
    {
        return $this->branches[$name] ?? null;
    }
}
