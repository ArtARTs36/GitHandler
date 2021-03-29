<?php

namespace ArtARTs36\GitHandler\Operations;

use ArtARTs36\GitHandler\Contracts\LogParser;
use ArtARTs36\GitHandler\Data\LogCollection;
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
                $this->newCommand()
                    ->addParameter('log')
                    ->addOption('oneline')
                    ->addOption('decorate')
                    ->addOption('graph')
                    ->addOptionWithValue('pretty', "format:'%H|%ad|%an|%ae|%Creset%s'")
                    ->addOptionWithValue('date', 'iso')
                    ->addParameter('|')
                    ->addParameter('less')
                    ->addCutOption('r')
            );

        if ($result === null) {
            throw new \UnexpectedValueException();
        }

        return $this->getLogger()->parse($result);
    }
}
