<?php

namespace ArtARTs36\GitHandler\Command\Groups\Contracts;

use ArtARTs36\GitHandler\Data\FileMatch;

interface GitGrepCommandGroup
{
    /**
     * @return array<FileMatch>
     */
    public function grep(string $term): array;
}
