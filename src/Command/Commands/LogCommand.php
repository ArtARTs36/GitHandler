<?php

namespace ArtARTs36\GitHandler\Command\Commands;

use ArtARTs36\GitHandler\Command\GitCommandBuilder;
use ArtARTs36\GitHandler\Contracts\Commands\GitLogCommand;
use ArtARTs36\GitHandler\Contracts\LogParser;
use ArtARTs36\GitHandler\Data\LogCollection;
use ArtARTs36\GitHandler\Enum\FormatPlaceholder;
use ArtARTs36\GitHandler\Exceptions\BranchDoesNotHaveCommits;
use ArtARTs36\ShellCommand\Exceptions\UserExceptionTrigger;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandExecutor;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\ShellCommand\Result\CommandResult;

class LogCommand extends AbstractCommand implements GitLogCommand
{
    protected $parser;

    public function __construct(LogParser $parser, GitCommandBuilder $builder, ShellCommandExecutor $executor)
    {
        $this->parser = $parser;

        parent::__construct($builder, $executor);
    }

    public function getAll(): ?LogCollection
    {
        return $this->executeAndParseLogCommand($this->buildLogCommand());
    }

    public function logForFile(string $filename): ?LogCollection
    {
        return $this->executeAndParseLogCommand($this->buildLogCommand()->addArgument($filename));
    }

    public function logForFileOnLines(string $filename, int $startLine, int $endLine): ?LogCollection
    {
        return $this->executeAndParseLogCommand(
            $this
                ->buildLogCommand()
                ->addCutOption('L')
                ->addArgument("$startLine,$endLine:$filename", false)
        );
    }

    protected function executeAndParseLogCommand(ShellCommandInterface $command): ?LogCollection
    {
        return $this->parser->parse($command->executeOrFail($this->executor)->getResult());
    }

    protected function buildLogCommand(): ShellCommandInterface
    {
        return $this->builder->make()
            ->addArgument('log')
            ->addOption('oneline')
            ->addOption('decorate')
            ->addOption('graph')
            ->addOptionWithValue('pretty', "format:'|log-entry|%H|%ad|%an|%ae|%Creset%s|'")
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
            ]));
    }
}
