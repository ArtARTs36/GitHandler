<?php

namespace ArtARTs36\GitHandler\Command\Groups\Contracts;

use ArtARTs36\GitHandler\Data\Hook;

interface GitHookCommandGroup
{
    /**
     * @see HookName for $name
     */
    public function add(string $name, string $script): bool;

    /**
     * @see HookName for $name
     */
    public function has(string $name): bool;

    /**
     * @see HookName for $name
     * @covers \ArtARTs36\GitHandler\Exceptions\HookNotExists
     */
    public function delete(string $name): bool;

    /**
     * @see HookName for $name
     * @covers \ArtARTs36\GitHandler\Exceptions\HookNotExists
     */
    public function get(string $name): Hook;

    /**
     * @return array<string, Hook>
     */
    public function getAll(bool $onlyWorked = true): array;

    public function getHookPath(?string $name = null): string;
}
