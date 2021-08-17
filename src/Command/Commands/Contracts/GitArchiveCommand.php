<?php

namespace ArtARTs36\GitHandler\Command\Commands\Contracts;

/**
 * Git Archive
 */
interface GitArchiveCommand
{
    /**
     * Create git archive
     * @git-command git archive --output-path=$path
     */
    public function create(string $path): void;
}
