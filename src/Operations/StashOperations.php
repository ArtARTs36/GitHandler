<?php

namespace ArtARTs36\GitHandler\Operations;

use ArtARTs36\GitHandler\Data\Stash;
use ArtARTs36\GitHandler\Exceptions\StashDoesNotExists;
use ArtARTs36\GitHandler\Exceptions\UnexpectedException;
use ArtARTs36\GitHandler\Support\FormatPlaceholder;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\ShellCommand\ShellCommand;
use ArtARTs36\Str\Str;

trait StashOperations
{
    abstract protected function newCommand(?string $dir = null): ShellCommandInterface;

    abstract protected function executeCommand(ShellCommand $command): ?Str;

    public function stash(?string $message = null): bool
    {
        return
            $this
                ->executeCommand($this->newCommand()
                    ->addArgument('stash')
                    ->when($message !== null, function (ShellCommand $command) use ($message) {
                        $command
                            ->addArgument('save')
                            ->addArgument('"'. $message .'"');
                    }))
                ->containsAny([
                    'Saved working directory and index',
                    'No local changes to save',
                ]);
    }

    public function unStash(): bool
    {
        return
            $this->executeCommand(
                $this->newCommand()
                ->addArgument('stash')
                ->addArgument('pop')
            )->contains('Changes not staged for commit:');
    }

    /**
     * @return array<Stash>
     */
    public function getStashList(): array
    {
        $result = $this->executeCommand($this->newCommand()
            ->addOption('no-pager')
            ->addArgument('stash')
            ->addArgument('list')
            ->addOptionWithValue('pretty', FormatPlaceholder::format([
                FormatPlaceholder::REFLOG_SHORTENED_SELECTOR,
                FormatPlaceholder::REFLOG_SUBJECT,
            ])));

        if ($result === null || $result->isEmpty()) {
            return [];
        }

        $stashes = [];

        foreach ($result->globalMatch('/stash@{(.*)}\|.*on (.*):(.*)/i') as $data) {
            $stashes[] = new Stash($data[1], $data[2], trim($data[3]));
        }

        return $stashes;
    }

    public function applyStash(int $id): bool
    {
        $result = $this->executeCommand(
            $cmd = $this->newCommand()
                ->addArgument('stash')
                ->addArgument('apply')
                ->addArgument('stash@{'. $id . '}')
        );

        if ($result->contains('Changes not staged for commit') ||
            $result->contains('Changes to be committed')) {
            return true;
        }

        if ($result->contains("fatal: Log for 'stash' only has (.*) entries")) {
            throw new StashDoesNotExists($id);
        }

        throw new UnexpectedException($cmd);
    }
}
