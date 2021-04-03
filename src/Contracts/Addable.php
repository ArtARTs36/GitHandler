<?php

namespace ArtARTs36\GitHandler\Contracts;

interface Addable
{
    /**
     * @param string $file - file name to git added
     */
    public function add(string $file, bool $force = false): bool;
}
