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

    /**
     * Create archive with .git/refs
     */
    public function packRefs(string $path): void;

    /**
     * Unpack archive with .git/refs
     */
    public function unpackRefs(string $path): void;
}
