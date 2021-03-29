<?php

namespace ArtARTs36\GitHandler\Operations;

use ArtARTs36\GitHandler\Data\Remotes;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\ShellCommand\ShellCommand;
use ArtARTs36\Str\Facade\Str;

trait RemoteOperations
{
    abstract protected function newCommand(?string $dir = null): ShellCommandInterface;

    abstract protected function executeCommand(ShellCommand $command): ?string;

    /**
     * @inheritDoc
     */
    public function showRemote(): Remotes
    {
        $sh = $this->executeShowRemote();

        if (! Str::containsAny($sh, ['Fetch(\s*)URL', 'Push(\s*)URL:'])) {
            return Remotes::createEmpty();
        }

        //

        $getUrl = function (string $regular) use ($sh) {
            $matches = [];

            preg_match($regular, $sh, $matches);

            return end($matches);
        };

        //

        return new Remotes($getUrl('/Fetch(\s*)URL: (.*)\n/'), $getUrl('/Push(\s*)URL: (.*)\n/'));
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
    protected function executeShowRemote(): string
    {
        return $this
            ->executeCommand($this->newCommand()
                ->addParameter('remote')
                ->addParameter('show')
                ->addParameter('origin'));
    }
}
