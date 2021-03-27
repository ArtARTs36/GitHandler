<?php

namespace ArtARTs36\GitHandler;

use ArtARTs36\GitHandler\Contracts\GitHandler;
use ArtARTs36\GitHandler\Data\Remotes;
use ArtARTs36\GitHandler\Exceptions\BranchNotFound;
use ArtARTs36\GitHandler\Exceptions\FileNotFound;
use ArtARTs36\GitHandler\Exceptions\PathAlreadyExists;
use ArtARTs36\GitHandler\Exceptions\TagAlreadyExist;
use ArtARTs36\GitHandler\Support\FileSystem;
use ArtARTs36\ShellCommand\ShellCommand;
use ArtARTs36\Str\Facade\Str;

class Git extends AbstractGitHandler implements GitHandler
{
    /**
     * @inheritDoc
     */
    public function pull(?string $branch = null): bool
    {
        $sh = $this->executeCommand($this->newCommand()
            ->addParameter('pull')
            ->when($branch !== null, function (ShellCommand $command) use ($branch) {
                $command->addParameter($branch);
            }));

        return Str::contains($sh, 'Already up to date') ||
            (Str::contains($sh, 'Receiving objects') && Str::contains($sh, 'Resolving deltas'));
    }

    /**
     * @inheritDoc
     */
    public function init(): bool
    {
        return Str::contains($this
            ->executeCommand($this->newCommand()
            ->addParameter('init')), 'Initialized empty Git repository');
    }

    /**
     * @inheritDoc
     */
    public function checkout(string $branch): bool
    {
        $sh = $this->executeCommand($this->newCommand()
            ->addParameter('checkout')
            ->addParameter($branch));

        BranchNotFound::handleIfSo($branch, $sh);

        return true;
    }

    /**
     * @inheritDoc
     */
    public function status(bool $short = false): string
    {
        return $this->executeCommand(
            $this->newCommand()
                ->addParameter('status')
                ->when($short, function (ShellCommand $command) {
                    $command->addCutOption('s');
                })
        );
    }

    /**
     * @inheritDoc
     */
    public function add(string $file): bool
    {
        $sh = $this->executeCommand($this->newCommand()
            ->addParameter('add')
            ->addParameter($file));

        if (empty($sh)) {
            return true;
        }

        FileNotFound::handleIfSo($file, $sh);

        return false;
    }

    /**
     * @inheritDoc
     */
    public function clone(string $url, ?string $branch = null): bool
    {
        $command = $this->newCommand(FileSystem::belowPath($this->getDir()))
            ->addParameter('clone')
            ->when($branch !== null, function (ShellCommand $command) use ($branch) {
                $command
                    ->addCutOption('b')
                    ->addParameter($branch);
            })
            ->addParameter($url)
            ->addParameter($folder = FileSystem::endFolder($this->getDir()));

        //

        $sh = $this->executeCommand($command);

        //

        if (Str::contains($sh, "Cloning into '{$folder}'")) {
            return true;
        }

        PathAlreadyExists::handleIfSo($folder, $sh);

        return false;
    }

    /**
     * @inheritDoc
     */
    public function stash(?string $message = null): bool
    {
        $sh = $this->executeCommand($this->newCommand()
            ->addParameter('stash')
            ->when($message !== null, function (ShellCommand $command) use ($message) {
                $command
                    ->addParameter('save')
                    ->addParameter('"'. $message .'"');
            }));

        return Str::contains($sh, 'Saved working directory and index') ||
            Str::contains($sh, 'No local changes to save');
    }

    /**
     * equals: git remote show origin
     */
    public function showRemote(): Remotes
    {
        $sh = $this->executeShowRemote();

        if (! Str::contains($sh, 'Fetch(\s*)URL') || ! Str::contains($sh, 'Push(\s*)URL:')) {
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

    public function getTags(?string $pattern = null): array
    {
        $raw = $this->newCommand()
            ->addParameter('tag')
            ->when($pattern !== null, function (ShellCommand $command) use ($pattern) {
                $command
                    ->addCutOption('l')
                    ->addParameter($pattern, true);
            })
            ->getShellResult();

        if (empty($raw)) {
            return [];
        }

        return explode("\n", trim($raw));
    }

    /**
     * @throws TagAlreadyExist
     */
    public function performTag(string $tag, ?string $message = null): bool
    {
        if ($this->isTagExists($tag)) {
            throw new TagAlreadyExist($tag);
        }

        return $this->newCommand()
            ->addParameter('tag')
            ->addCutOption('a')
            ->addParameter($tag)
            ->addCutOption('m')
            ->addParameter($message ?? "Version {$tag}", true)
            ->getShellResult() === null;
    }

    public function isTagExists(string $tag): bool
    {
        return in_array($tag, $this->getTags());
    }

    public function addRemote(string $shortName, string $url): bool
    {
        return $this
            ->newCommand()
            ->addParameter('remote')
            ->addParameter('add')
            ->addParameter($shortName)
            ->addParameter($url)
            ->getShellResult() === null;
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
