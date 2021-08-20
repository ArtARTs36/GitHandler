<?php

namespace ArtARTs36\GitHandler\Contracts\Commands;

/**
 * Git Ignore Files (.gitignore)
 */
interface GitIgnoreCommand
{
    /**
     * @return array<string>
     */
    public function files(): array;

    /**
     * Add file to .gitignore
     */
    public function add(string $path): bool;

    /**
     * Has file in .gitignore
     */
    public function has(string $path): bool;

    /**
     * Get full path to file ".gitignore"
     */
    public function getPathToFile(): string;
}
