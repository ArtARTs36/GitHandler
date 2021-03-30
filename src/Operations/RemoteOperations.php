<?php

namespace ArtARTs36\GitHandler\Operations;

use ArtARTs36\GitHandler\Data\Remotes;
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

    public function addRemote(string $shortName, string $url): bool
    {
        return $this
                ->executeCommand(
                    $this->newCommand()
                        ->addParameter('remote')
                        ->addParameter('add')
                        ->addParameter($shortName)
                        ->addParameter($url)
                ) === null;
    }

    /**
     * equals: git remote show origin
     */
    protected function executeShowRemote(): Str
    {
        return $this
            ->executeCommand($this->newCommand()
                ->addParameter('remote')
                ->addParameter('show')
                ->addParameter('origin'));
    }
}
