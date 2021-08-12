<?php

namespace ArtARTs36\GitHandler\Command\Groups\Contracts;

interface GitHelpCommandGroup
{
    /**
     * Get git help information
     * equals: git --help
     */
    public function get(): string;
}
