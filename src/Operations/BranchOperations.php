<?php

namespace ArtARTs36\GitHandler\Operations;

use ArtARTs36\GitHandler\Exceptions\AlreadySwitched;
use ArtARTs36\GitHandler\Exceptions\BranchAlreadyExists;
use ArtARTs36\GitHandler\Exceptions\BranchNotFound;
use ArtARTs36\GitHandler\Exceptions\ObjectNameNotValid;
use ArtARTs36\GitHandler\Exceptions\ReferenceInvalid;
use ArtARTs36\GitHandler\Exceptions\UnexpectedException;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\ShellCommand\ShellCommand;
use ArtARTs36\Str\Str;

trait BranchOperations
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

    public function deleteBranch(string $branch): bool
    {
        $result = $this->executeCommand(
            $cmd = $this
                ->newCommand()
                ->addParameter('branch')
                ->addCutOption('d')
                ->addParameter($branch)
        );

        if ($result === null || $result->isEmpty()) {
            throw new UnexpectedException($cmd);
        }

        if ($result->contains("Deleted branch $branch")) {
            return true;
        }

        if ($result->contains("error: branch '$branch' not found")) {
            throw new BranchNotFound($branch);
        }

        throw new UnexpectedException($cmd);
    }

    public function newBranch(string $branch): bool
    {
        $result = $this->executeCommand(
            $cmd = $this->newCommand()->addParameter('branch')->addParameter($branch)
        );

        if ($result === null || $result->isEmpty()) {
            return true;
        }

        if (($already = $result->match("/fatal: A branch named '$branch' already exists/i"))
            && $already->isNotEmpty()) {
            throw new BranchAlreadyExists($branch);
        }

        if (($objectName = $result->match('/fatal: Not a valid object name: \'(.*)\'/i')) &&
            $objectName->isNotEmpty()) {
            throw new ObjectNameNotValid($objectName);
        }

        throw new UnexpectedException($cmd);
    }

    public function getBranches(): array
    {
        $result = $this->executeCommand(
            $this
                ->newCommand()
                ->addParameter('branch')
                ->addCutOption('a')
        );

        if ($result === null || $result->isEmpty()) {
            return [];
        }

        return array_map('trim', $result->trim()->replace([
            '* master' => 'master',
        ])->lines());
    }

    public function switchBranch(string $branch): bool
    {
        $result = $this->executeCommand(
            $cmd = $this
                ->newCommand()
                ->addParameter('switch')
                ->addParameter($branch)
        );

        if ($result === null) {
            throw new UnexpectedException($cmd);
        }

        if ($result->contains("Switched to branch '$branch'")) {
            return true;
        }

        if ($result->contains('fatal: invalid reference: '. $branch)) {
            throw new ReferenceInvalid($branch);
        }

        if ($result->contains("Already on '$branch'")) {
            throw new AlreadySwitched($branch);
        }

        throw new UnexpectedException($cmd);
    }
}
