<?php

namespace ArtARTs36\GitHandler;

use ArtARTs36\GitHandler\Contracts\GitHandler;
use ArtARTs36\ShellCommand\Interfaces\CommandBuilder;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandExecutor;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\ShellCommand\ShellCommand;
use ArtARTs36\Str\Str;

abstract class AbstractGitHandler implements GitHandler
{
    private $dir;

    protected $bin;

    protected $executor;

    protected $builder;

    /**
     * @param string $dir - directory to project .git
     * @param string $bin - git bin
     * @codeCoverageIgnore
     */
    public function __construct(
        string $dir,
        ShellCommandExecutor $executor,
        CommandBuilder $builder,
        string $bin = 'git'
    ) {
        $this->dir = $dir;
        $this->bin = $bin;
        $this->executor = $executor;
        $this->builder = $builder;
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
        $result = $this->executor->execute($command);

        return $result->getResult()->appendLine($result->getError())->trim();
    }

    /**
     * @codeCoverageIgnore
     */
    protected function newCommand(?string $dir = null): ShellCommandInterface
    {
        return $this->builder->makeNavigateToDir($dir ?? $this->getDir(), $this->bin);
    }
}
