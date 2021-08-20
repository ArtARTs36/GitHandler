<?php

namespace ArtARTs36\GitHandler\Command\Commands;

use ArtARTs36\GitHandler\Contracts\Commands\GitMergeCommand;
use ArtARTs36\GitHandler\Exceptions\MergeHeadMissing;
use ArtARTs36\ShellCommand\Exceptions\UserExceptionTrigger;
use ArtARTs36\ShellCommand\Result\CommandResult;

class MergeCommand extends AbstractCommand implements GitMergeCommand
{
    public function mergeWithBranch(string $branch): void
    {
        $this
            ->builder
            ->make()
            ->addArgument('merge')
            ->addArgument($branch)
            ->executeOrFail($this->executor);
    }

    public function abort(): void
    {
        $this
            ->builder
            ->make()
            ->addArgument('merge')
            ->addOption('abort')
            ->setExceptionTrigger(UserExceptionTrigger::fromCallbacks([
                function (CommandResult $result) {
                    if ($result
                        ->getError()
                        ->contains('fatal: There is no merge to abort \(MERGE_HEAD missing\)')) {
                        throw new MergeHeadMissing();
                    }
                }
            ]))
            ->executeOrFail($this->executor);
    }
}
