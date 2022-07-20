<?php

namespace ArtARTs36\GitHandler\Config\Subjects;

use ArtARTs36\GitHandler\Contracts\Config\ConfigSubjectList;

/**
 * @template-implements \IteratorAggregate<string, ConfigSubmodule>
 */
class ConfigSubmoduleList extends AbstractSubject implements \IteratorAggregate
{
    public $submodules;

    /**
     * @param array<string, ConfigSubmodule> $submodules
     */
    public function __construct(array $submodules)
    {
        $this->submodules = $submodules;
    }

    public function get(string $name): ?ConfigSubmodule
    {
        return $this->submodules[$name] ?? null;
    }

    /**
     * @return iterable<string, ConfigSubmodule>
     */
    public function getIterator(): iterable
    {
        return new \ArrayIterator($this->submodules);
    }
}
