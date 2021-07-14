<?php

namespace ArtARTs36\GitHandler\Operations;

use ArtARTs36\GitHandler\Exceptions\BranchHasNoUpstream;
use ArtARTs36\GitHandler\Exceptions\UnexpectedException;
use ArtARTs36\GitHandler\Support\BranchBadName;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\ShellCommand\ShellCommand;
use ArtARTs36\Str\Str;

trait PushOperations
{
    abstract protected function newCommand(?string $dir = null): ShellCommandInterface;

    abstract protected function executeCommand(ShellCommand $command): ?Str;

    public function push(bool $force = false, ?string $upStream = null): bool
    {
        $result = $this->executeCommand(
            $command = $this
                ->newCommand()
                ->addParameter('push')
                ->when($force, function (ShellCommandInterface $command) {
                    $command->addOption('force');
                })
                ->when(! empty($upStream), function (ShellCommandInterface $command) use ($upStream) {
                    $command->addOption('set-upstream')->addParameter($upStream);
                })
        );

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

    public function pushOnAutoSetUpStream(bool $force = false): bool
    {
        $upstream = null;

        if (($branch = $this->getCurrentBranch()) && ! BranchBadName::is($branch)) {
            $upstream = 'origin '. $branch;
        }

        return $this->push($force, $upstream);
    }
}
