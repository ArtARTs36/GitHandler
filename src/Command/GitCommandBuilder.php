<?php

namespace ArtARTs36\GitHandler\Command;

use ArtARTs36\ShellCommand\Interfaces\CommandBuilder;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;

class GitCommandBuilder
{
    protected $builder;

    protected $bin;

    protected $dir;

    public function __construct(CommandBuilder $builder, string $bin, string $dir)
    {
        $this->builder = $builder;
        $this->bin = $bin;
        $this->dir = $dir;
    }

    public function make(?string $dir = null): ShellCommandInterface
    {
        return $this->builder->makeNavigateToDir($dir ?? $this->dir, $this->bin);
    }
}
