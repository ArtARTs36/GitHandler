<?php

namespace ArtARTs36\GitHandler\Config\Subjects;

class Branch extends AbstractSubject
{
    public $branches;

    /**
     * @param array<string, LinkBranch> $branches
     */
    public function __construct(array $branches)
    {
        $this->branches = $branches;
    }

    public function getBranch(string $name): ?LinkBranch
    {
        return $this->branches[$name] ?? null;
    }
}
