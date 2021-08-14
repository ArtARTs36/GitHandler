<?php

namespace ArtARTs36\GitHandler\Command\Groups\Contracts;

interface GitIgnoreCommand
{
    /**
     * @return array<string>
     */
    public function files(): array;

    public function add(string $path): bool;

    public function has(string $path): bool;

    public function getPathToFile(): string;
}
