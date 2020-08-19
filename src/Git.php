<?php

namespace ArtARTs36\GitHandler;

use ArtARTs36\GitHandler\Exceptions\BranchNotFound;
use ArtARTs36\GitHandler\Exceptions\FileNotFound;
use ArtARTs36\GitHandler\Exceptions\PathAlreadyExists;
use ArtARTs36\GitHandler\Support\FileSystem;
use ArtARTs36\GitHandler\Support\Str;
use ArtARTs36\ShellCommand\ShellCommand;

/**
 * Class Git
 * @package ArtARTs36\HostReviewerCore\Git
 */
class Git
{
    /** @var string */
    protected $dir;

    /** @var string */
    protected $executor;

    /**
     * Git constructor.
     * @param string $dir
     * @param string $executor
     */
    public function __construct(string $dir, string $executor = 'git')
    {
        $this->dir = $dir;
        $this->executor = $executor;
    }

    /**
     * equals: git pull
     * equals: git pull <branch>
     * @param string|null $branch
     * @return bool
     */
    public function pull(string $branch = null): bool
    {
        $sh = $this->executeCommand($this->newCommand()
            ->addParameter('pull')
            ->when(!empty($branch), function (ShellCommand $command) use ($branch) {
                $command->addParameter($branch);
            }));

        if (Str::contains($sh, 'Already up to date')) {
            return true;
        }

        if (Str::contains($sh, 'Receiving objects') && Str::contains($sh, 'Resolving deltas')) {
            return true;
        }

        return false;
    }

    /**
     * equals: git init
     * @return bool
     */
    public function init(): bool
    {
        $sh = $this->executeCommand($this->newCommand()
            ->addParameter('init'));

        if (Str::contains($sh, 'Initialized empty Git repository')) {
            return true;
        }

        return false;
    }

    /**
     * equals: git checkout <branch>
     * @param string $branch
     * @return bool
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
     * equals: git status
     * @param bool $short
     * @return string
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
     * @param string $file
     * @return bool
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
     * equals: git clone <url> <folder>
     * @param string $url
     * @return bool
     */
    public function clone(string $url): bool
    {
        $sh = $this->executeCommand($this->newCommand(FileSystem::belowPath($this->dir))
            ->addParameter('clone')
            ->addParameter($url)
            ->addParameter($folder = FileSystem::endFolder($this->dir)));

        if (Str::contains($sh, "Cloning into '{$folder}'")) {
            return true;
        }

        PathAlreadyExists::handleIfSo($folder, $sh);

        return false;
    }

    /**
     * equals: git stash
     * @param string $message
     * @return bool
     */
    public function stash(string $message = null): bool
    {
        $sh = $this->executeCommand($this->newCommand()
            ->addParameter('stash')
            ->when(!empty($message), function (ShellCommand $command) use ($message) {
                $command
                    ->addParameter('save')
                    ->addParameter('"'. $message .'"');
            }));

        if (Str::contains($sh, 'Saved working directory and index') ||
            Str::contains($sh, 'No local changes to save')
        ) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    public function getDir(): string
    {
        return $this->dir;
    }

    /**
     * @param ShellCommand $command
     * @return string|null
     */
    protected function executeCommand(ShellCommand $command)
    {
        return $command->getShellResult();
    }

    /**
     * @param null $dir
     * @return ShellCommand
     */
    protected function newCommand($dir = null): ShellCommand
    {
        return ShellCommand::getInstanceWithMoveDir($dir ?? $this->dir, $this->executor);
    }
}
