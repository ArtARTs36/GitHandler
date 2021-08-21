<?php

namespace ArtARTs36\GitHandler\Contracts\Commands;

interface RefsPacker
{
    /**
     * Create archive with .git/refs
     */
    public function packRefs(string $path): void;

    /**
     * Unpack archive with .git/refs
     */
    public function unpackRefs(string $path): void;
}
