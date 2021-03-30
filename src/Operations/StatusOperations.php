<?php

namespace ArtARTs36\GitHandler\Operations;

use ArtARTs36\GitHandler\Support\StatusResult;
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
        $status = $this->status(true)->trim();
        $groups = $this->getGroupsByStatusResult($status);

        return $status->isEmpty() ||
                ! array_key_exists(StatusResult::GROUP_MODIFIED, $groups) ||
                ! array_key_exists(StatusResult::GROUP_ADDED, $groups);
    }

    public function getUntrackedFiles(): array
    {
        return $this
                ->getGroupsByStatusResult($this->status(true)->trim())[StatusResult::GROUP_UNTRACKED] ?? [];
    }

    public function getModifiedFiles(): array
    {
        return $this->getGroupsByStatusResult($this->status(true)->trim())[StatusResult::GROUP_MODIFIED] ?? [];
    }

    public function getAddedFiles(): array
    {
        return $this->getGroupsByStatusResult($this->status(true)->trim())[StatusResult::GROUP_ADDED] ?? [];
    }

    protected function getGroupsByStatusResult(Str $result): array
    {
        $groups = [];

        foreach ($result->lines() as $line) {
            [$group, $file] = $line->trim()->explode(' ');

            $groups[$group->__toString()][] = $file->__toString();
        }

        return $groups;
    }
}
