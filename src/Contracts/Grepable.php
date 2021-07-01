<?php

namespace ArtARTs36\GitHandler\Contracts;

use ArtARTs36\GitHandler\Data\FileMatch;

interface Grepable
{
    /**
     * @return array<FileMatch>
     */
    public function grep(string $term): array;
}
