<?php

namespace ArtARTs36\GitHandler\Operations;

use ArtARTs36\GitHandler\Exceptions\BranchHasNoUpstream;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\ShellCommand\ShellCommand;
use ArtARTs36\Str\Str;

trait PushOperations
{
    abstract protected function newCommand(?string $dir = null): ShellCommandInterface;

    abstract protected function executeCommand(ShellCommand $command): ?Str;

    public function push(bool $force = false): bool
    {
        $result = $this->executeCommand(
            $this
                ->newCommand()
                ->addParameter('push')
                ->when($force, function (ShellCommandInterface $command) {
                    $command->addOption('force');
                })
        );

        if ($result === null) {
            return false;
        }

        $this->handleErrorByPushResult($result);

        return $result->containsAny([
            'Everything up-to-date',
            '->',
            'Enumerating objects:',
        ]);
    }

    protected function handleErrorByPushResult(Str $result): void
    {
        $this->handleErrorBranchHasNoUpstream($result);
    }

    protected function handleErrorBranchHasNoUpstream(Str $result): void
    {
        if ($result->contains($errPattern = BranchHasNoUpstream::patternStdError())) {
            throw new BranchHasNoUpstream($result->match('/'. $errPattern . '/i'));
        }
    }
}
