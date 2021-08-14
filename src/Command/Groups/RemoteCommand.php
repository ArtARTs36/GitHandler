<?php

namespace ArtARTs36\GitHandler\Command\Groups;

use ArtARTs36\GitHandler\Command\Groups\Contracts\GitRemoteCommand;
use ArtARTs36\GitHandler\Data\Remotes;
use ArtARTs36\GitHandler\Exceptions\RemoteAlreadyExists;
use ArtARTs36\GitHandler\Exceptions\RemoteNotFound;
use ArtARTs36\GitHandler\Exceptions\RemoteRepositoryNotFound;
use ArtARTs36\GitHandler\Exceptions\UnexpectedException;
use ArtARTs36\ShellCommand\Exceptions\UserExceptionTrigger;
use ArtARTs36\ShellCommand\Result\CommandResult;
use ArtARTs36\Str\Str;

class RemoteCommand extends AbstractCommandGroup implements GitRemoteCommand
{
    public function showRemote(): Remotes
    {
        $sh = $this->executeShowRemote();

        return new Remotes(
            $sh->match('/origin\s+(.*)\(fetch\)/')->trim(),
            $sh->match('/origin\s+(.*)\(push\)/')->trim()
        );
    }

    public function hasAnyRemoteUrl(string $url): bool
    {
        return ($remotes = $this->showRemote()) && ($remotes->fetch->equals($url) || $remotes->push->equals($url));
    }

    /**
     * @inheritDoc
     */
    public function removeRemote(string $shortName): bool
    {
        return $this
            ->builder
            ->make()
            ->addArgument('remote')
            ->addArgument('remove')
            ->addArgument($shortName)
            ->setExceptionTrigger(UserExceptionTrigger::fromCallbacks([
                function (CommandResult $result) {
                    if (($notFound = $result->getError()->match("/No such remote: '(.*)'/i")) &&
                        ! $notFound->isEmpty()) {
                        throw new RemoteNotFound($notFound);
                    }
                }
            ]))
            ->executeOrFail($this->executor)
            ->isOk();
    }

    /**
     * @inheritDoc
     */
    public function addRemote(string $shortName, string $url): bool
    {
        return $this
            ->builder
            ->make()
            ->addArgument('remote')
            ->addArgument('add')
            ->addArgument($shortName)
            ->addArgument($url)
            ->setExceptionTrigger(UserExceptionTrigger::fromCallbacks([
                function (CommandResult $result) {
                    if (($already = $result->getError()->match('/remote (.*) already exists/i')) &&
                        ! $already->isEmpty()) {
                        throw new RemoteAlreadyExists($already);
                    }
                }
            ]))
            ->executeOrFail($this->executor)
            ->isOk();
    }

    /**
     * equals: git remote -v
     */
    protected function executeShowRemote(): Str
    {
        return $this
            ->builder
            ->make()
            ->addArgument('remote')
            ->addOption('v')
            ->setExceptionTrigger(UserExceptionTrigger::fromCallbacks([
                function (CommandResult $result) {
                    if (($failed = $result->getError()->match("/repository '(.*)' not found/i")) &&
                        $failed->isNotEmpty()) {
                        throw new RemoteRepositoryNotFound($failed);
                    }
                }
            ]))
            ->executeOrFail($this->executor)
            ->getResult();
    }
}
