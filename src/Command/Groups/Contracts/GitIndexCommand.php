<?php

namespace ArtARTs36\GitHandler\Command\Groups\Contracts;

interface GitIndexCommand
{
    /**
     * @param string|array<string> $file - file name to git added
     */
    public function add($file, bool $force = false): bool;
}
