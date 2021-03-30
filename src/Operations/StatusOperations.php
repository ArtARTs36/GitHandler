<?php

namespace ArtARTs36\GitHandler\Operations;

use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\ShellCommand\ShellCommand;
use ArtARTs36\Str\Str;

trait StatusOperations
{
    abstract protected function newCommand(?string $dir = null): ShellCommandInterface;

    abstract protected function executeCommand(ShellCommand $command): ?Str;

    public function status(bool $short = false): Str
    {
        return $this->executeCommand(
            $this->newCommand()
                ->addParameter('status')
                ->when($short, function (ShellCommand $command) {
                    $command->addCutOption('s');
                })
        );
    }

    public function hasChanges(): bool
    {
        return ! empty(trim($this->status(true)));
    }
}
