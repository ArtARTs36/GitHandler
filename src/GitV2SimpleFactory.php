<?php

namespace ArtARTs36\GitHandler;

use ArtARTs36\GitHandler\Command\GitCommandBuilder;
use ArtARTs36\ShellCommand\Executors\ProcOpenExecutor;
use ArtARTs36\ShellCommand\ShellCommander;

class GitV2SimpleFactory
{
    public static function factory(string $dir, string $bin = 'git'): GitV2
    {
        return new GitV2(
            new GitCommandBuilder(new ShellCommander(), $bin, $dir),
            new ProcOpenExecutor(),
            $dir
        );
    }
}
