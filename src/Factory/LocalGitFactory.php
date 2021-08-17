<?php

namespace ArtARTs36\GitHandler\Factory;

use ArtARTs36\GitHandler\Command\GitCommandBuilder;
use ArtARTs36\GitHandler\Contracts\Factory\GitHandlerFactory;
use ArtARTs36\GitHandler\Contracts\Handler\GitHandler;
use ArtARTs36\GitHandler\GitContext;
use ArtARTs36\GitHandler\GitV2;
use ArtARTs36\GitHandler\Support\LocalFileSystem;
use ArtARTs36\ShellCommand\Executors\ProcOpenExecutor;
use ArtARTs36\ShellCommand\ShellCommander;

class LocalGitFactory implements GitHandlerFactory
{
    public function factory(string $dir, string $bin = 'git'): GitHandler
    {
        return new GitV2(
            new GitCommandBuilder(new ShellCommander(), $bin, $dir),
            new ProcOpenExecutor(),
            new LocalFileSystem(),
            GitContext::make($dir)
        );
    }
}
