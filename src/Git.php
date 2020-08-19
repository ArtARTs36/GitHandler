<?php

namespace ArtARTs36\GitHandler;

use ArtARTs36\GitHandler\Exceptions\BranchNotFound;
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
            })
        );

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
     * @param ShellCommand $command
     * @return string|null
     */
    protected function executeCommand(ShellCommand $command)
    {
        return $command->getShellResult();
    }

    /**
     * @return ShellCommand
     */
    protected function newCommand(): ShellCommand
    {
        return ShellCommand::getInstanceWithMoveDir($this->dir, $this->executor);
    }
}
