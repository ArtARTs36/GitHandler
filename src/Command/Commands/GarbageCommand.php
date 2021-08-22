<?php

namespace ArtARTs36\GitHandler\Command\Commands;

use ArtARTs36\GitHandler\Contracts\Commands\GitGarbageCommand;
use ArtARTs36\GitHandler\Enum\GarbageCollectMode;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\ShellCommand\Result\CommandResult;

class GarbageCommand extends AbstractCommand implements GitGarbageCommand
{
    public function collect(GarbageCollectMode $mode): bool
    {
        return $this->analyzeCollectAnswer($this->buildPureCommand($mode)->executeOrFail($this->executor));
    }

    public function collectOnDate(GarbageCollectMode $mode, \DateTimeInterface $date): bool
    {
        return $this->analyzeCollectAnswer($this
            ->buildPureCommand($mode)
            ->addOptionWithValue('prune', $date->format('Y-m-d'))
            ->executeOrFail($this->executor));
    }

    protected function analyzeCollectAnswer(CommandResult $result): bool
    {
        if ($result->getResult()->contains('Nothing new to pack.')) {
            return false;
        }

        return true;
    }

    protected function buildPureCommand(GarbageCollectMode $mode): ShellCommandInterface
    {
        return $this->builder->make()->addArgument('gc')->addOption($mode->value);
    }
}
