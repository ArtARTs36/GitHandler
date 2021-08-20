<?php

namespace ArtARTs36\GitHandler\Command\Commands;

use ArtARTs36\GitHandler\Contracts\Commands\GitFetchCommand;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;

class FetchCommand extends AbstractCommand implements GitFetchCommand
{
    public function fetch(): void
    {
        $this->buildFetchCommand()->executeOrFail($this->executor);
    }

    public function fetchAll(): void
    {
        $this->buildFetchCommand()->addOption('all')->executeOrFail($this->executor);
    }

    protected function buildFetchCommand(): ShellCommandInterface
    {
        return $this->builder->make()->addArgument('fetch');
    }
}
