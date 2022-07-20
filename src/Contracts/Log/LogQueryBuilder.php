<?php

namespace ArtARTs36\GitHandler\Contracts\Log;

use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;

interface LogQueryBuilder extends LogQuery
{
    /**
     * Build this query
     */
    public function build(ShellCommandInterface $command): ShellCommandInterface;
}
