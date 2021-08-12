<?php

namespace ArtARTs36\GitHandler\Command\Groups;

use ArtARTs36\GitHandler\Command\GitCommandBuilder;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandExecutor;

abstract class AbstractCommandGroup
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
