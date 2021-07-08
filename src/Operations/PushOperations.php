<?php

namespace ArtARTs36\GitHandler\Operations;

use ArtARTs36\GitHandler\Exceptions\BranchHasNoUpstream;
use ArtARTs36\GitHandler\Exceptions\UnexpectedException;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\ShellCommand\ShellCommand;
use ArtARTs36\Str\Str;

trait PushOperations
{
    abstract protected function newCommand(?string $dir = null): ShellCommandInterface;

    abstract protected function executeCommand(ShellCommand $command): ?Str;

    public function push(bool $force = false): bool
    {
        return $this->executePushCommand($this->buildPushCommand($force));
    }

    protected function executePushCommand(ShellCommandInterface $command): bool
    {
        $result = $this->executeCommand($command);

        if ($result === null || $result->isEmpty()) {
            throw new UnexpectedException($command);
        }

        if ($result->contains($errPattern = BranchHasNoUpstream::patternStdError())) {
            throw new BranchHasNoUpstream($result->match('/'. $errPattern . '/i'));
        }

        return $result->containsAny([
            'Everything up-to-date',
            '->',
            'Enumerating objects:',
        ]);
    }

    protected function buildPushCommand(bool $force): ShellCommandInterface
    {
        return $this
            ->newCommand()
            ->addParameter('push')
            ->when($force, function (ShellCommandInterface $command) {
                $command->addOption('force');
            });
    }
}
