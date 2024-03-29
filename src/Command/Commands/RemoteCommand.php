<?php

namespace ArtARTs36\GitHandler\Command\Commands;

use ArtARTs36\GitHandler\Contracts\Commands\GitRemoteCommand;
use ArtARTs36\GitHandler\Data\Remotes;
use ArtARTs36\GitHandler\Exceptions\RemoteAlreadyExists;
use ArtARTs36\GitHandler\Exceptions\RemoteNotFound;
use ArtARTs36\GitHandler\Exceptions\RemoteRepositoryNotFound;
use ArtARTs36\GitHandler\Exceptions\UnexpectedException;
use ArtARTs36\ShellCommand\Exceptions\UserExceptionTrigger;
use ArtARTs36\ShellCommand\Result\CommandResult;
use ArtARTs36\Str\Str;

class RemoteCommand extends AbstractCommand implements GitRemoteCommand
{
    public function show(): Remotes
    {
        $sh = $this->executeShowRemote();

        return new Remotes(
            $sh->match('/origin\s+(.*)\(fetch\)/')->trim(),
            $sh->match('/origin\s+(.*)\(push\)/')->trim()
        );
    }

    public function hasAnyRemoteUrl(string $url): bool
    {
        $remotes = $this->show();

        return $remotes->fetch->equals($url) || $remotes->push->equals($url);
    }

    /**
     * @inheritDoc
     */
    public function remove(string $shortName): bool
    {
        return $this
            ->builder
            ->make()
            ->addArgument('remote')
            ->addArgument('remove')
            ->addArgument($shortName)
            ->setExceptionTrigger(UserExceptionTrigger::fromCallbacks([
                function (CommandResult $result) {
                    $notFound = $result->getError()->match("/No such remote: '(.*)'/i");
                    if ($notFound->isNotEmpty()) {
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
    public function add(string $shortName, string $url): bool
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
                    $already = $result->getError()->match('/remote (.*) already exists/i');
                    if ($already->isNotEmpty()) {
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
                    $failed = $result->getError()->match("/repository '(.*)' not found/i");
                    if ($failed->isNotEmpty()) {
                        throw new RemoteRepositoryNotFound($failed);
                    }
                }
            ]))
            ->executeOrFail($this->executor)
            ->getResult();
    }
}
