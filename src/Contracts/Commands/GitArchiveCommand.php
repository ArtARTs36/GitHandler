<?php

namespace ArtARTs36\GitHandler\Contracts\Commands;

use ArtARTs36\GitHandler\Exceptions\PathIsDirectoryNotCould;

/**
 * Git Archive
 */
interface GitArchiveCommand
{
    /**
     * Create git archive
     * @git-command git archive --output=$path HEAD
     * @throws PathIsDirectoryNotCould
     */
    public function create(string $path): void;
}
