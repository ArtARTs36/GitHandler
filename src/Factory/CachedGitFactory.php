<?php

namespace ArtARTs36\GitHandler\Factory;

use ArtARTs36\GitHandler\CachedGit;
use ArtARTs36\GitHandler\Contracts\Factory\GitHandlerFactory;
use ArtARTs36\GitHandler\Contracts\Handler\GitHandler;

class CachedGitFactory implements GitHandlerFactory
{
    protected $factory;

    public function __construct(GitHandlerFactory $factory)
    {
        $this->factory = $factory;
    }

    public function factory(string $dir, string $bin = 'git'): GitHandler
    {
        return new CachedGit($this->factory->factory($dir, $bin));
    }
}
