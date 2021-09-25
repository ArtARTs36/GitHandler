<?php

namespace ArtARTs36\GitHandler\Config\Subjects;

class AliasList extends AbstractSubject
{
    public $aliases;

    /**
     * @param array<string, Alias> $aliases
     */
    public function __construct(array $aliases)
    {
        $this->aliases = $aliases;
    }
}
