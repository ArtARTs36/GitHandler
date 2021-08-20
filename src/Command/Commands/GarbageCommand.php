<?php

namespace ArtARTs36\GitHandler\Command\Commands;

use ArtARTs36\GitHandler\Contracts\Commands\GitGarbageCommand;
use ArtARTs36\GitHandler\Enum\GarbageCollectMode;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;

class GarbageCommand extends AbstractCommand implements GitGarbageCommand
{
    public function collect(GarbageCollectMode $mode): void
    {
        $this->buildPureCommand($mode)->executeOrFail($this->executor);
    }

    public function collectOnDate(GarbageCollectMode $mode, \DateTimeInterface $date): void
    {
        $this
            ->buildPureCommand($mode)
            ->addOptionWithValue('prune', $date->format('Y-m-d'))
            ->executeOrFail($this->executor);
    }

    protected function buildPureCommand(GarbageCollectMode $mode): ShellCommandInterface
    {
        return $this->builder->make()->addArgument('gc')->addOption($mode->value);
    }
}
