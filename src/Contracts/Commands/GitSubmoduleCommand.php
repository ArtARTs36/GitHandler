<?php

namespace ArtARTs36\GitHandler\Contracts\Commands;

/**
 * Git Submodule
 */
interface GitSubmoduleCommand
{
    /**
     * Add git submodule
     * @git-command git submodule add $url
     */
    public function add(string $url): void;

    public function getAll(): array;
}
