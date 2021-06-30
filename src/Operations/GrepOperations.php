<?php

namespace ArtARTs36\GitHandler\Operations;

use ArtARTs36\GitHandler\Data\Match;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\ShellCommand\ShellCommand;
use ArtARTs36\Str\Str;

trait GrepOperations
{
    private $grepRegex = '/(?<file>.*)\:(?<line>\d+)\:(?<content>.*)\n/i';

    abstract protected function newCommand(?string $dir = null): ShellCommandInterface;

    abstract protected function executeCommand(ShellCommand $command): ?Str;

    /**
     * @return array<Match>
     */
    public function grep(string $term): array
    {
        $result = $this->executeCommand(
            $this->newCommand()
                ->addOption('no-pager')
                ->addParameter('grep')
                ->addCutOption('n')
                ->addParameter($term, true)
        );

        if ($result === null || $result->isEmpty()) {
            return [];
        }

        $matches = [];

        foreach ($result->globalMatch($this->grepRegex) as $match) {
            $matches[] = Match::fromArray($match);
        }

        return $matches;
    }
}
