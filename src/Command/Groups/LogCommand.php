<?php

namespace ArtARTs36\GitHandler\Command\Groups;

use ArtARTs36\GitHandler\Command\GitCommandBuilder;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitLogCommand;
use ArtARTs36\GitHandler\Contracts\LogParser;
use ArtARTs36\GitHandler\Data\LogCollection;
use ArtARTs36\GitHandler\Exceptions\BranchDoesNotHaveCommits;
use ArtARTs36\ShellCommand\Exceptions\UserExceptionTrigger;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandExecutor;
use ArtARTs36\ShellCommand\Result\CommandResult;

class LogCommand extends AbstractCommand implements GitLogCommand
{
    protected $parser;

    /** @codeCoverageIgnore */
    public function __construct(LogParser $parser, GitCommandBuilder $builder, ShellCommandExecutor $executor)
    {
        $this->parser = $parser;

        parent::__construct($builder, $executor);
    }

    public function getAll(): ?LogCollection
    {
        return $this->parser->parse($this->builder->make()
            ->addArgument('log')
            ->addOption('oneline')
            ->addOption('decorate')
            ->addOption('graph')
            ->addOptionWithValue('pretty', "format:'%H|%ad|%an|%ae|%Creset%s'")
            ->addOptionWithValue('date', 'iso')
            ->setExceptionTrigger(UserExceptionTrigger::fromCallbacks([
                function (CommandResult $result) {
                    $branch = $result
                        ->getError()
                        ->match("/fatal: your current branch '(.*)' does not have any commits yet/i");

                    if ($branch->isNotEmpty()) {
                        throw new BranchDoesNotHaveCommits($branch);
                    }
                }
            ]))
            ->executeOrFail($this->executor)->getResult());
    }
}
