<?php

namespace ArtARTs36\GitHandler\Operations;

use ArtARTs36\GitHandler\Exceptions\BranchNotFound;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\ShellCommand\ShellCommand;
use ArtARTs36\Str\Str;

trait CheckoutOperations
{
    abstract protected function newCommand(?string $dir = null): ShellCommandInterface;

    abstract protected function executeCommand(ShellCommand $command): ?Str;

    /**
     * @inheritDoc
     */
    public function checkout(string $branch, bool $merge = false): bool
    {
        $sh = $this
            ->executeCommand(
                $this
                    ->newCommand()
                    ->addParameter('checkout')
                    ->addParameter($branch)
                    ->when($merge, function (ShellCommandInterface $command) {
                        $command->addOption('merge');
                    })
            );

        BranchNotFound::handleIfSo($branch, $sh);

        return true;
    }
}
