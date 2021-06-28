<?php

namespace ArtARTs36\GitHandler;

use ArtARTs36\GitHandler\Contracts\GitHandler;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\ShellCommand\ShellCommand;
use ArtARTs36\Str\Str;

abstract class AbstractGitHandler implements GitHandler
{
    private $dir;

    protected $executor;

    /**
     * @param Str $dir - directory to project .git
     * @param string $executor - git bin
     * @codeCoverageIgnore
     */
    public function __construct(Str $dir, string $executor = 'git')
    {
        $this->dir = $dir;
        $this->executor = $executor;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDir(): Str
    {
        return $this->dir;
    }

    /**
     * @codeCoverageIgnore
     */
    protected function executeCommand(ShellCommand $command): ?Str
    {
        return ($result = $command->getShellResult()) ? Str::make($result) : null;
    }

    /**
     * @codeCoverageIgnore
     */
    protected function newCommand(?string $dir = null): ShellCommandInterface
    {
        return ShellCommand::getInstanceWithMoveDir($dir ?? $this->getDir(), $this->executor);
    }
}
