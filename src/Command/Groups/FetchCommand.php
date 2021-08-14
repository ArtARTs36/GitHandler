<?php

namespace ArtARTs36\GitHandler\Command\Groups;

use ArtARTs36\GitHandler\Command\Groups\Contracts\GitFetchCommand;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;

class FetchCommand extends AbstractCommandGroup implements GitFetchCommand
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
