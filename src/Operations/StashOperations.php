<?php

namespace ArtARTs36\GitHandler\Operations;

use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\ShellCommand\ShellCommand;
use ArtARTs36\Str\Str;

trait StashOperations
{
    abstract protected function newCommand(?string $dir = null): ShellCommandInterface;

    abstract protected function executeCommand(ShellCommand $command): ?Str;

    /**
     * @inheritDoc
     */
    public function stash(?string $message = null): bool
    {
        return
            $this
                ->executeCommand($this->newCommand()
                    ->addParameter('stash')
                    ->when($message !== null, function (ShellCommand $command) use ($message) {
                        $command
                            ->addParameter('save')
                            ->addParameter('"'. $message .'"');
                    }))
                ->containsAny([
                    'Saved working directory and index',
                    'No local changes to save',
                ]);
    }

    public function unStash(): bool
    {
        $res = $this->executeCommand($this->newCommand()
            ->addParameter('stash')
        ->addParameter('pop'));

        return
            $res->contains('');
    }
}
