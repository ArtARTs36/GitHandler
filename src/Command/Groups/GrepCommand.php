<?php

namespace ArtARTs36\GitHandler\Command\Groups;

use ArtARTs36\GitHandler\Command\Groups\Contracts\GitGrepCommandGroup;
use ArtARTs36\GitHandler\Data\FileMatch;

class GrepCommand extends AbstractCommand implements GitGrepCommandGroup
{
    private $grepRegex = '/(?<file>.*)\:(?<line>\d+)\:(?<content>.*)\n?/i';

    public function grep(string $term): array
    {
        $result = $this->builder->make()
                ->addOption('no-pager')
                ->addArgument('grep')
                ->addCutOption('n')
                ->addArgument($term, true)
                ->executeOrFail($this->executor)
                ->getResult();

        if ($result->isEmpty()) {
            return [];
        }

        $matches = [];

        foreach ($result->globalMatch($this->grepRegex) as $match) {
            $matches[] = FileMatch::fromArray($match);
        }

        return $matches;
    }
}
