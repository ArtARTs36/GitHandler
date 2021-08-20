<?php

namespace ArtARTs36\GitHandler\Command;

use ArtARTs36\ShellCommand\Interfaces\CommandBuilder;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;

class GitCommandBuilder
{
    protected $builder;

    protected $bin;

    protected $dir;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(CommandBuilder $builder, string $bin, string $dir)
    {
        $this->builder = $builder;
        $this->bin = $bin;
        $this->dir = $dir;
    }

    /**
     * @todo rename to 'git'
     */
    public function make(?string $dir = null): ShellCommandInterface
    {
        return $this->builder->makeNavigateToDir($dir ?? $this->dir, $this->bin);
    }

    /**
     * @codeCoverageIgnore
     */
    public function toDir(string $dir, string $bin): ShellCommandInterface
    {
        return $this->builder->makeNavigateToDir($dir, $bin);
    }
}
