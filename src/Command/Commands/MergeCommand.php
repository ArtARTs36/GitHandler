<?php

namespace ArtARTs36\GitHandler\Command\Commands;

use ArtARTs36\GitHandler\Contracts\Commands\GitMergeCommand;
use ArtARTs36\GitHandler\Exceptions\MergeHeadMissing;
use ArtARTs36\ShellCommand\Exceptions\UserExceptionTrigger;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\ShellCommand\Result\CommandResult;

class MergeCommand extends AbstractCommand implements GitMergeCommand
{
    public function merge(string $branch, ?string $message = null): void
    {
        $this->buildMergeCommand($branch, $message)->executeOrFail($this->executor);
    }

    public function mergeSquash(string $branch, ?string $message = null): void
    {
        $this->buildMergeCommand($branch, $message)->addOption('squash')->executeOrFail($this->executor);
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

    protected function buildMergeCommand(string $branch, ?string $message = null): ShellCommandInterface
    {
        return $this
            ->builder
            ->make()
            ->addArgument('merge')
            ->addArgument($branch)
            ->when($message !== null, function (ShellCommandInterface $command) use ($message) {
                $command->addCutOption('m')->addArgument($message);
            });
    }
}
