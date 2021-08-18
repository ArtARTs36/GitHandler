<?php

namespace ArtARTs36\GitHandler\Command\Commands\Contracts;

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
