<?php

namespace ArtARTs36\GitHandler\Command\Commands;

use ArtARTs36\GitHandler\Contracts\Commands\GitStashCommand;
use ArtARTs36\GitHandler\Data\Stash;
use ArtARTs36\GitHandler\Exceptions\StashDoesNotExists;
use ArtARTs36\GitHandler\Exceptions\UnexpectedException;
use ArtARTs36\GitHandler\Enum\FormatPlaceholder;
use ArtARTs36\ShellCommand\Exceptions\UserExceptionTrigger;
use ArtARTs36\ShellCommand\Result\CommandResult;
use ArtARTs36\ShellCommand\ShellCommand;

class StashCommand extends AbstractCommand implements GitStashCommand
{
    public function stash(?string $message = null): bool
    {
        return $this
            ->builder
            ->make()
            ->addArgument('stash')
            ->when($message !== null, function (ShellCommand $command) use ($message) {
                $command
                    ->addArgument('save')
                    ->addArgument('"'. $message .'"');
            })
            ->executeOrFail($this->executor)
            ->getResult()
            ->containsAny([
                'Saved working directory and index',
                'No local changes to save',
            ]);
    }

    public function pop(): bool
    {
        return $this
            ->builder
            ->make()
            ->addArgument('stash')
            ->addArgument('pop')
            ->executeOrFail($this->executor)
            ->getResult()
            ->contains('Changes not staged for commit:');
    }

    /**
     * @return array<Stash>
     */
    public function getStashList(): array
    {
        $result = $this
            ->builder
            ->make()
            ->addOption('no-pager')
            ->addArgument('stash')
            ->addArgument('list')
            ->addOptionWithValue('pretty', FormatPlaceholder::format([
                FormatPlaceholder::REFLOG_SHORTENED_SELECTOR,
                FormatPlaceholder::REFLOG_SUBJECT,
            ]))
            ->executeOrFail($this->executor)
            ->getResult();

        return array_map(function (array $data) {
            return new Stash($data[1], $data[2], trim($data[3]));
        }, $result->globalMatch('/stash@{(.*)}\|.*on (.*):(.*)/i'));
    }

    public function applyStash(int $id): bool
    {
        return $this
            ->builder
            ->make()
            ->addArgument('stash')
            ->addArgument('apply')
            ->addArgument('stash@{'. $id . '}')
            ->setExceptionTrigger(UserExceptionTrigger::fromCallbacks([
                function (CommandResult $result) use ($id) {
                    if ($result->getError()->contains("fatal: Log for 'stash' only has (.*) entries")) {
                        throw new StashDoesNotExists($id);
                    }
                }
            ]))
            ->executeOrFail($this->executor)
            ->getResult()
            ->containsAny(['Changes not staged for commit', 'Changes to be committed']);
    }
}
