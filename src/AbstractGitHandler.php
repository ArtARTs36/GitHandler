<?php

namespace ArtARTs36\GitHandler;

use ArtARTs36\GitHandler\Contracts\GitHandler;
use ArtARTs36\ShellCommand\ShellCommand;

abstract class AbstractGitHandler implements GitHandler
{
    private $dir;

    protected $executor;

    /**
     * @param string $dir - directory to project .git
     * @param string $executor - git bin
     */
    public function __construct(string $dir, string $executor = 'git')
    {
        $this->dir = $dir;
        $this->executor = $executor;
    }

    public function getDir(): string
    {
        return $this->dir;
    }

    protected function executeCommand(ShellCommand $command)
    {
        return $command->getShellResult();
    }

    protected function newCommand($dir = null): ShellCommand
    {
        return ShellCommand::getInstanceWithMoveDir($dir ?? $this->getDir(), $this->executor);
    }
}
