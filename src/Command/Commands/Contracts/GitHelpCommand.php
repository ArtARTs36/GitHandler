<?php

namespace ArtARTs36\GitHandler\Command\Commands\Contracts;

/**
 * Git Help
 */
interface GitHelpCommand
{
    /**
     * Get git help information
     * @git-command git --help
     */
    public function get(): string;
}
