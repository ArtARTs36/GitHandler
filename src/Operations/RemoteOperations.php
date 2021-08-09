<?php

namespace ArtARTs36\GitHandler\Operations;

use ArtARTs36\GitHandler\Data\Remotes;
use ArtARTs36\GitHandler\Exceptions\RemoteAlreadyExists;
use ArtARTs36\GitHandler\Exceptions\RemoteNotFound;
use ArtARTs36\GitHandler\Exceptions\RemoteRepositoryNotFound;
use ArtARTs36\GitHandler\Exceptions\UnexpectedException;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\ShellCommand\ShellCommand;
use ArtARTs36\Str\Str;

trait RemoteOperations
{
    abstract protected function newCommand(?string $dir = null): ShellCommandInterface;

    abstract protected function executeCommand(ShellCommand $command): ?Str;

    /**
     * @inheritDoc
     */
    public function showRemote(): Remotes
    {
        $sh = $this->executeShowRemote();

        if ($sh === null || ($sh && ! $sh->containsAny(['Fetch(\s*)URL', 'Push(\s*)URL:']))) {
            return Remotes::createEmpty();
        }

        return new Remotes(
            $sh->match('/Fetch(\s*)URL: (.*)\n/'),
            $sh->match('/Push(\s*)URL: (.*)\n/')
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
        $result = $this->executeCommand(
            $cmd = $this
                ->newCommand()
                ->addArgument('remote')
                ->addArgument('remove')
                ->addArgument($shortName)
        );

        if ($result === null || $result->isEmpty()) {
            return true;
        }

        if (($notFound = $result->match("/No such remote: '(.*)'/i")) && ! $notFound->isEmpty()) {
            throw new RemoteNotFound($notFound);
        }

        throw new UnexpectedException($cmd);
    }

    /**
     * @inheritDoc
     */
    public function addRemote(string $shortName, string $url): bool
    {
        $result = $this->executeCommand(
            $cmd = $this->newCommand()
                ->addArgument('remote')
                ->addArgument('add')
                ->addArgument($shortName)
                ->addArgument($url)
        );

        if ($result === null || $result->isEmpty()) {
            return true;
        }

        if (($alreadyExists = $result->match('/remote (.*) already exists/i')) && ! $alreadyExists->isEmpty()) {
            throw new RemoteAlreadyExists($alreadyExists);
        }

        throw new UnexpectedException($cmd);
    }

    /**
     * equals: git remote show origin
     */
    protected function executeShowRemote(): ?Str
    {
        $result = $this->executeCommand($this->newCommand()
                ->addArgument('remote')
                ->addArgument('show')
                ->addArgument('origin'));

        if ($result && ($failed = $result->match("/repository '(.*)' not found/i")) && $failed->isNotEmpty()) {
            throw new RemoteRepositoryNotFound($failed);
        }

        return $result;
    }
}
