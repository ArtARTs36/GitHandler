<?php

namespace ArtARTs36\GitHandler\Operations;

use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\ShellCommand\ShellCommand;
use ArtARTs36\Str\Str;

trait FetchOperations
{
    abstract protected function newCommand(?string $dir = null): ShellCommandInterface;

    abstract protected function executeCommand(ShellCommand $command): ?Str;

    public function fetch(): void
    {
        $this->executeCommand($this->buildFetchCommand());
    }

    public function fetchAll(): void
    {
        $this->executeCommand($this->buildFetchCommand()->addOption('all'));
    }

    protected function buildFetchCommand(): ShellCommandInterface
    {
        return $this->newCommand()->addParameter('fetch');
    }
}
