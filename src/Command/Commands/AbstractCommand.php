<?php

namespace ArtARTs36\GitHandler\Command\Commands;

use ArtARTs36\GitHandler\Command\GitCommandBuilder;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandExecutor;

abstract class AbstractCommand
{
    protected $builder;

    protected $executor;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(GitCommandBuilder $builder, ShellCommandExecutor $executor)
    {
        $this->builder = $builder;
        $this->executor = $executor;
    }
}
