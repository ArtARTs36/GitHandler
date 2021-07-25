<?php

namespace ArtARTs36\GitHandler\Contracts;

interface HasHooks
{
    /**
     * @see HookName for $name
     */
    public function addHook(string $name, string $script): bool;

    /**
     * @see HookName for $name
     */
    public function hasHook(string $name): bool;

    /**
     * @see HookName for $name
     */
    public function deleteHook(string $name): bool;
}
