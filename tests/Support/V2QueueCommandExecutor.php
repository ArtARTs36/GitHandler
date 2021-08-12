<?php

namespace ArtARTs36\GitHandler\Tests\Support;

use ArtARTs36\ShellCommand\Interfaces\ShellCommandExecutor;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\ShellCommand\Result\CommandResult;
use ArtARTs36\ShellCommand\Result\ResultCode;
use ArtARTs36\Str\Str;

class V2QueueCommandExecutor implements ShellCommandExecutor
{
    protected $results;

    public function execute(ShellCommandInterface $command): CommandResult
    {
        $creator = array_shift($this->results);

        return $creator($command);
    }

    public function nextFailed(string $error = ''): self
    {
        $this->results[] = function (string $command) use ($error) {
            return new CommandResult(
                $command,
                Str::fromEmpty(),
                new \DateTime(),
                Str::make($error),
                ResultCode::GENERAL_ERRORS
            );
        };

        return $this;
    }

    public function nextOk(string $result = ''): self
    {
        $this->results[] = function (string $command) use ($result) {
            return new CommandResult(
                $command,
                Str::make($result),
                new \DateTime(),
                Str::fromEmpty(),
                ResultCode::OK
            );
        };

        return $this;
    }
}
