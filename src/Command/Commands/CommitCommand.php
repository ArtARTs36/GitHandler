<?php

namespace ArtARTs36\GitHandler\Command\Commands;

use ArtARTs36\GitHandler\Command\GitCommandBuilder;
use ArtARTs36\GitHandler\Contracts\Commands\GitIndexCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitCommitCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitStatusCommand;
use ArtARTs36\GitHandler\Data\Author;
use ArtARTs36\GitHandler\Exceptions\NothingToCommit;
use ArtARTs36\ShellCommand\Exceptions\UserExceptionTrigger;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandExecutor;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\ShellCommand\Result\CommandResult;

class CommitCommand extends AbstractCommand implements GitCommitCommand
{
    protected $adds;

    protected $statuses;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(
        GitIndexCommand $adds,
        GitStatusCommand $statuses,
        GitCommandBuilder $builder,
        ShellCommandExecutor $executor
    ) {
        $this->adds = $adds;
        $this->statuses = $statuses;

        parent::__construct($builder, $executor);
    }

    public function commit(string $message, bool $amend = false, ?Author $author = null): bool
    {
        return $this
            ->builder
            ->make()
            ->addArgument('commit')
            ->when($author !== null, function (ShellCommandInterface $command) use ($author) {
                $command->addOptionWithValue('author', $author);
            })
            ->addCutOption('m')
            ->addArgument($message, true)
            ->when($amend === true, function (ShellCommandInterface $command) {
                $command->addOption('amend');
            })
            ->setExceptionTrigger(UserExceptionTrigger::fromCallbacks([
                function (CommandResult $result) {
                    if ($result->getError()->contains('nothing to commit')) {
                        throw new NothingToCommit();
                    }
                }
            ]))
            ->executeOrFail($this->executor)
            ->getResult()
            ->contains('file changed');
    }

    /**
     * equals: git add (untracked files) && git commit -m $message
     * @codeCoverageIgnore
     */
    public function autoCommit(string $message, bool $amend = false): bool
    {
        $this->adds->add($this->statuses->getModifiedFiles());

        return $this->commit($message, $amend);
    }
}
