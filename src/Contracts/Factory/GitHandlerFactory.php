<?php

namespace ArtARTs36\GitHandler\Contracts\Factory;

use ArtARTs36\GitHandler\Contracts\Handler\GitHandler;

interface GitHandlerFactory
{
    public function factory(string $dir, string $bin = 'git'): GitHandler;
}
