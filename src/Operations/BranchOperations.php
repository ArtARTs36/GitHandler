<?php

namespace ArtARTs36\GitHandler\Operations;

use ArtARTs36\GitHandler\Exceptions\BranchAlreadyExists;
use ArtARTs36\GitHandler\Exceptions\BranchNotFound;
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

        return false;
    }

    public function newBranch(string $branch): bool
    {
        $result = $this->executeCommand(
            $this->newCommand()->addParameter('branch')->addParameter($branch)
        );

        if ($result === null || $result->isEmpty()) {
            return true;
        }

        if (($already = $result->match("/fatal: A branch named '$branch' already exists/i"))
            && $already->isNotEmpty()) {
            throw new BranchAlreadyExists($branch);
        }

        return false;
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
}
