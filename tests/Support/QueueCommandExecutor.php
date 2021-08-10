<?php

namespace ArtARTs36\GitHandler\Tests\Support;

use ArtARTs36\ShellCommand\Interfaces\ShellCommandExecutor;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\ShellCommand\Result\CommandResult;
use ArtARTs36\Str\Str;

class QueueCommandExecutor implements ShellCommandExecutor
{
    protected $results;

    public function __construct(array $results)
    {
        $this->results = array_map(function ($result) {
            return Str::make($result)->trim();
        }, $results);
    }

    public function execute(ShellCommandInterface $command): CommandResult
    {
        return new CommandResult(
            $command,
            array_shift($this->results) ?? Str::fromEmpty(),
            new \DateTime(),
            Str::fromEmpty(),
            0
        );
    }
}
