<?php

namespace ArtARTs36\GitHandler\Operations;

use ArtARTs36\GitHandler\Contracts\LogParser;
use ArtARTs36\GitHandler\Data\LogCollection;
use ArtARTs36\GitHandler\Exceptions\BranchDoesNotHaveCommits;
use ArtARTs36\GitHandler\Exceptions\UnexpectedException;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\ShellCommand\ShellCommand;
use ArtARTs36\Str\Str;

trait LogOperations
{
    abstract protected function newCommand(?string $dir = null): ShellCommandInterface;

    abstract protected function executeCommand(ShellCommand $command): ?Str;

    abstract protected function getLogger(): LogParser;

    public function log(): ?LogCollection
    {
        $result = $this
            ->executeCommand(
                $cmd = $this->newCommand()
                    ->addArgument('log')
                    ->addOption('oneline')
                    ->addOption('decorate')
                    ->addOption('graph')
                    ->addOptionWithValue('pretty', "format:'%H|%ad|%an|%ae|%Creset%s'")
                    ->addOptionWithValue('date', 'iso')
                    ->setErrorFlow('&1')
            );

        if ($result->isEmpty()) {
            throw new UnexpectedException($cmd);
        }

        if (($branch = $result->match("/fatal: your current branch '(.*)' does not have any commits yet/i")) &&
            $branch->isNotEmpty()) {
            throw new BranchDoesNotHaveCommits($branch);
        }

        return $this->getLogger()->parse($result);
    }
}
