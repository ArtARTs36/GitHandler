<?php

namespace ArtARTs36\GitHandler\Command\Commands;

use ArtARTs36\GitHandler\Command\GitCommandBuilder;
use ArtARTs36\GitHandler\Contracts\Commands\GitBranchCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitPushCommand;
use ArtARTs36\GitHandler\Exceptions\BranchHasNoUpstream;
use ArtARTs36\GitHandler\Enum\BranchBadName;
use ArtARTs36\ShellCommand\Exceptions\UserExceptionTrigger;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandExecutor;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\ShellCommand\Result\CommandResult;

class PushCommand extends AbstractCommand implements GitPushCommand
{
    protected $branches;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(
        GitBranchCommand $branches,
        GitCommandBuilder $builder,
        ShellCommandExecutor $executor
    ) {
        $this->branches = $branches;

        parent::__construct($builder, $executor);
    }

    public function push(bool $force = false, ?string $upStream = null): bool
    {
        return $this
            ->builder
            ->make()
            ->addArgument('push')
            ->when($force, function (ShellCommandInterface $command) {
                $command->addOption('force');
            })
            ->when(! empty($upStream), function (ShellCommandInterface $command) use ($upStream) {
                $command->addOption('set-upstream')->addArgument($upStream);
            })
            ->setExceptionTrigger(UserExceptionTrigger::fromCallbacks([
                function (CommandResult $result) {
                    if ($result->getError()->contains($errPattern = BranchHasNoUpstream::patternStdError(), true)) {
                        throw new BranchHasNoUpstream($result->getResult()->match('/'. $errPattern . '/i'));
                    }
                }
            ]))
            ->executeOrFail($this->executor)
            ->getResult()
            ->containsAny([
                'Everything up-to-date',
                '->',
                'Enumerating objects:',
            ]);
    }

    public function pushOnAutoSetUpStream(bool $force = false): bool
    {
        $upstream = null;

        if (($branch = $this->branches->current()) && ! BranchBadName::is($branch)) {
            $upstream = 'origin '. $branch;
        }

        return $this->push($force, $upstream);
    }
}
