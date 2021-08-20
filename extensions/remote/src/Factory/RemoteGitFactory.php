<?php

namespace ArtARTs36\GitHandler\Factory;

use ArtARTs36\GitHandler\Command\GitCommandBuilder;
use ArtARTs36\GitHandler\Contracts\Factory\GitHandlerFactory;
use ArtARTs36\GitHandler\Contracts\Handler\GitHandler;
use ArtARTs36\GitHandler\Data\GitContext;
use ArtARTs36\GitHandler\Git;
use ArtARTs36\ShellCommand\Executors\Ssh\Connection;
use ArtARTs36\ShellCommand\Executors\Ssh\SshCommandExecutor;
use ArtARTs36\ShellCommand\ShellCommander;

class RemoteGitFactory implements GitHandlerFactory
{
    protected $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function factory(string $dir, string $bin = 'git'): GitHandler
    {
        $executor = new SshCommandExecutor($this->connection, false, $builder = new ShellCommander());

        return new Git(
            new GitCommandBuilder($builder, $bin, $dir),
            $executor,
            $executor->buildFileSystem(),
            GitContext::make($dir, $bin)
        );
    }
}
