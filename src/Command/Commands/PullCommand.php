<?php

namespace ArtARTs36\GitHandler\Command\Commands;

use ArtARTs36\GitHandler\Contracts\Commands\GitPullCommand;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;

class PullCommand extends AbstractCommand implements GitPullCommand
{
    protected static $okResults = [
        'Already up to date',
        'Receiving objects',
        'Resolving deltas',
    ];

    public function pull(): bool
    {
        return $this
            ->buildPurePullCommand()
            ->executeOrFail($this->executor)
            ->getResult()
            ->containsAny(static::$okResults);
    }

    public function pullBranch(string $branch): bool
    {
        return $this
            ->buildPurePullCommand()
            ->addArgument($branch)
            ->executeOrFail($this->executor)
            ->getResult()
            ->containsAny(static::$okResults);
    }

    protected function buildPurePullCommand(): ShellCommandInterface
    {
        return $this->builder->make()->addArgument('pull');
    }
}
