<?php

namespace ArtARTs36\GitHandler\Contracts;

use ArtARTs36\GitHandler\Data\Match;

interface Grepable
{
    /**
     * @return array<Match>
     */
    public function grep(string $term): array;
}
