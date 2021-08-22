<?php

namespace ArtARTs36\GitHandler\Contracts\Commands;

use ArtARTs36\GitHandler\Data\FileMatch;

/**
 * Git grep
 */
interface GitGrepCommand
{
    /**
     * Git grep
     * @git-command git grep -n $term
     * @return array<FileMatch>
     */
    public function grep(string $term): array;
}
