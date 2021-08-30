<?php

namespace ArtARTs36\GitHandler\Contracts\Factory;

use ArtARTs36\GitHandler\Contracts\Handler\GitHandler;

/**
 * Factory for create GitHandler instance
 */
interface GitHandlerFactory
{
    /**
     * @param string $dir - path to repository directory
     * @param string $bin - git binary
     */
    public function factory(string $dir, string $bin = 'git'): GitHandler;
}
