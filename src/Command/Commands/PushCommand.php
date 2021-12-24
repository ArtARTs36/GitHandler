<?php

namespace ArtARTs36\GitHandler\Command\Commands;

use ArtARTs36\GitHandler\Command\GitCommandBuilder;
use ArtARTs36\GitHandler\Contracts\Commands\GitBranchCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitConfigCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitPushCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitRemoteCommand;
use ArtARTs36\GitHandler\Exceptions\BranchHasNoUpstream;
use ArtARTs36\GitHandler\Enum\BranchBadName;
use ArtARTs36\GitHandler\Making\MakingPush;
use ArtARTs36\ShellCommand\Exceptions\UserExceptionTrigger;
use ArtARTs36\ShellCommand\Interfaces\ExceptionTrigger;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandExecutor;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\ShellCommand\Result\CommandResult;
use GuzzleHttp\Psr7\Uri;

class PushCommand extends AbstractCommand implements GitPushCommand
{
    protected $branches;

    protected $remotes;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(
        GitBranchCommand $branches,
        GitCommandBuilder $builder,
        ShellCommandExecutor $executor,
        GitRemoteCommand $remotes
    ) {
        $this->branches = $branches;
        $this->remotes = $remotes;

        parent::__construct($builder, $executor);
    }

    public function push(bool $force = false, ?string $upStream = null): bool
    {
        return $this
            ->buildPushCommand($force, $upStream)
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

    public function pushAllTags(bool $force = false, ?string $upStream = null): bool
    {
        return $this->pushWithOption('tags', $force, $upStream)->getError()->contains('[new tag]');
    }

    public function send(callable $making): void
    {
        $remotes = $this->remotes->show();

        $push = new MakingPush(new Uri($remotes->push));

        $making($push);

        $push
            ->buildCommand($this->builder->make())
            ->setExceptionTrigger($this->makeExceptionTrigger())
            ->executeOrFail($this->executor);
    }

    protected function pushWithOption(string $option, bool $force = false, ?string $upStream = null): CommandResult
    {
        return $this->buildPushCommand($force, $upStream)->addOption($option)->executeOrFail($this->executor);
    }

    protected function buildPushCommand(bool $force, ?string $upStream): ShellCommandInterface
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
            ->setExceptionTrigger($this->makeExceptionTrigger());
    }

    protected function makeExceptionTrigger(): ExceptionTrigger
    {
        return UserExceptionTrigger::fromCallbacks([
            function (CommandResult $result) {
                if ($result->getError()->contains($errPattern = BranchHasNoUpstream::patternStdError(), true)) {
                    throw new BranchHasNoUpstream($result->getResult()->match('/'. $errPattern . '/i'));
                }
            }
        ]);
    }
}
