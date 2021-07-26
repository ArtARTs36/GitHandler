<?php

namespace ArtARTs36\GitHandler\Contracts;

interface Addable
{
    /**
     * @param string|array<string> $file - file name to git added
     */
    public function add($file, bool $force = false): bool;
}
