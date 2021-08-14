<?php

namespace ArtARTs36\GitHandler\Command\Groups;

use ArtARTs36\GitHandler\Command\Groups\Contracts\GitStatusCommand;
use ArtARTs36\GitHandler\Support\StatusResult;
use ArtARTs36\ShellCommand\ShellCommand;
use ArtARTs36\Str\Str;

class StatusCommand extends AbstractCommandGroup implements GitStatusCommand
{
    public function status(bool $short = false): Str
    {
        return $this
            ->builder
            ->make()
            ->addArgument('status')
            ->when($short, function (ShellCommand $command) {
                $command->addCutOption('s');
            })
            ->executeOrFail($this->executor)
            ->getResult();
    }

    public function hasChanges(): bool
    {
        $status = $this->status(true)->trim();
        $groups = $this->getGroupsByStatusResult($status);

        return $status->isNotEmpty() && (
                ! array_key_exists(StatusResult::GROUP_MODIFIED, $groups) ||
                ! array_key_exists(StatusResult::GROUP_ADDED, $groups));
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

        if ($result->isEmpty()) {
            return [];
        }

        foreach ($result->lines() as $line) {
            [$group, $file] = $line->trim()->explode(' ');

            $groups[$group->__toString()][] = $file->__toString();
        }

        return $groups;
    }
}