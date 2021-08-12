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
     * @param string $dir - directory to project .git
     * @param string $executor - git bin
     * @codeCoverageIgnore
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
        return ShellCommand::withNavigateToDir($dir ?? $this->getDir(), $this->executor);
    }
}
