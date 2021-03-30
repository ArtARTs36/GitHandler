<?php

namespace ArtARTs36\GitHandler\Contracts;

use ArtARTs36\Str\Str;

interface Statusable
{
    /**
     * equals: git status
     */
    public function status(bool $short = false): Str;

    public function hasChanges(): bool;
}
