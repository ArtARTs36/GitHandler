<?php

namespace ArtARTs36\GitHandler\Tests\Support;

use ArtARTs36\ShellCommand\Interfaces\ShellCommandExecutor;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\ShellCommand\Result\CommandResult;
use ArtARTs36\ShellCommand\Result\ResultCode;
use ArtARTs36\Str\Str;
use PHPUnit\Framework\Assert;

class QueueCommandExecutor implements ShellCommandExecutor
{
    protected $results = [];

    protected $attempts = 0;

    public function execute(ShellCommandInterface $command): CommandResult
    {
        $this->attempts++;

        $creator = array_shift($this->results);

        if ($creator === null) {
            throw new \LogicException('Command not expected');
        }

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

    public function nextAttemptsOk(int $count): self
    {
        for ($i = 0; $i < $count; $i++) {
            $this->nextOk();
        }

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

    public function assertAttempts(int $expected): void
    {
        Assert::assertEquals($expected, $this->attempts);
    }
}
