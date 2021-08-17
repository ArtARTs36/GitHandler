<?php

namespace ArtARTs36\GitHandler\Command\Commands;

use ArtARTs36\GitHandler\Command\Commands\Contracts\GitBranchCommand;
use ArtARTs36\GitHandler\Exceptions\AlreadySwitched;
use ArtARTs36\GitHandler\Exceptions\BranchAlreadyExists;
use ArtARTs36\GitHandler\Exceptions\BranchNotFound;
use ArtARTs36\GitHandler\Exceptions\ObjectNameNotValid;
use ArtARTs36\GitHandler\Exceptions\ReferenceInvalid;
use ArtARTs36\ShellCommand\Exceptions\UserExceptionTrigger;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\ShellCommand\Result\CommandResult;
use ArtARTs36\Str\Str;

class BranchCommand extends AbstractCommand implements GitBranchCommand
{
    public function checkout(string $branch, bool $merge = false): bool
    {
        return $this
            ->builder
            ->make()
            ->addArgument('checkout')
            ->addArgument($branch)
            ->when($merge, function (ShellCommandInterface $command) {
                $command->addOption('merge');
            })
            ->setExceptionTrigger(UserExceptionTrigger::fromCallbacks([
                function (CommandResult $result) use ($branch) {
                    BranchNotFound::handleIfSo($branch, $result->getError());
                }
            ]))
            ->executeOrFail($this->executor)
            ->isOk();
    }

    public function delete(string $branch): bool
    {
        return $this
            ->builder
            ->make()
            ->addArgument('branch')
            ->addCutOption('d')
            ->addArgument($branch)
            ->setExceptionTrigger(UserExceptionTrigger::fromCallbacks([
                function (CommandResult $result) use ($branch) {
                    if ($result->getError()->contains("error: branch '$branch' not found")) {
                        throw new BranchNotFound($branch);
                    }
                }
            ]))
            ->executeOrFail($this->executor)
            ->getResult()
            ->contains("Deleted branch $branch");
    }

    public function newBranch(string $branch): bool
    {
        return $this
            ->builder
            ->make()
            ->addArgument('branch')
            ->addArgument($branch)
            ->setExceptionTrigger(UserExceptionTrigger::fromCallbacks([
                function (CommandResult $result) use ($branch) {
                    if (($already = $result->getError()->match("/fatal: A branch named '$branch' already exists/i"))
                        && $already->isNotEmpty()) {
                        throw new BranchAlreadyExists($branch);
                    }

                    if (($objectName = $result->getError()->match('/fatal: Not a valid object name: \'(.*)\'/i')) &&
                        $objectName->isNotEmpty()) {
                        throw new ObjectNameNotValid($objectName);
                    }
                }
            ]))
            ->executeOrFail($this->executor)
            ->isOk();
    }

    public function getBranches(): array
    {
        $result = $this
            ->builder
            ->make()
            ->addArgument('branch')
            ->addCutOption('a')
            ->executeOrFail($this->executor);

        if ($result->isEmpty()) {
            return [];
        }

        return array_map('trim', $result->getResult()->trim()->replace([
            '* master' => 'master',
        ])->lines());
    }

    public function getCurrentBranch(): Str
    {
        return $this
            ->builder
            ->make()
            ->addArgument('branch')
            ->addOption('show-current')
            ->executeOrFail($this->executor)
            ->getResult()
            ->trim();
    }

    public function switchBranch(string $branch): bool
    {
        return $this
            ->builder
            ->make()
            ->addArgument('switch')
            ->addArgument($branch)
            ->setExceptionTrigger(UserExceptionTrigger::fromCallbacks([
                function (CommandResult $result) use ($branch) {
                    if ($result->getError()->contains('fatal: invalid reference: '. $branch)) {
                        throw new ReferenceInvalid($branch);
                    }

                    if ($result->getError()->contains("Already on '$branch'")) {
                        throw new AlreadySwitched($branch);
                    }
                }
            ]))
            ->executeOrFail($this->executor)
            ->getResult()
            ->contains("Switched to branch '$branch'");
    }
}