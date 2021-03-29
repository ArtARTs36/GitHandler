<?php

namespace ArtARTs36\GitHandler;

use ArtARTs36\GitHandler\Contracts\ConfigResultParser;
use ArtARTs36\GitHandler\Contracts\GitHandler;
use ArtARTs36\GitHandler\Contracts\LogParser;
use ArtARTs36\GitHandler\Exceptions\BranchNotFound;
use ArtARTs36\GitHandler\Exceptions\FileNotFound;
use ArtARTs36\GitHandler\Exceptions\NothingToCommit;
use ArtARTs36\GitHandler\Exceptions\PathAlreadyExists;
use ArtARTs36\GitHandler\Operations\ConfigOperations;
use ArtARTs36\GitHandler\Operations\InitOperations;
use ArtARTs36\GitHandler\Operations\LogOperations;
use ArtARTs36\GitHandler\Operations\RemoteOperations;
use ArtARTs36\GitHandler\Operations\TagOperations;
use ArtARTs36\GitHandler\Support\FileSystem;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\ShellCommand\ShellCommand;
use ArtARTs36\Str\Facade\Str;

class Git extends AbstractGitHandler implements GitHandler
{
    use ConfigOperations;
    use InitOperations;
    use TagOperations;
    use LogOperations;
    use RemoteOperations;

    protected $logger;

    private $config;

    public function __construct(string $dir, LogParser $logger, ConfigResultParser $config, string $executor = 'git')
    {
        parent::__construct($dir, $executor);

        $this->logger = $logger;
        $this->config = $config;
    }

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

    public function push(): bool
    {
        $result = $this->executeCommand($this->newCommand()->addParameter('push'));

        if ($result === null) {
            return false;
        }

        return Str::contains($result, 'Everything up-to-date')
            || Str::contains($result, '->')
            || Str::contains($result, 'Enumerating objects:');
    }

    public function commit(string $message, bool $amend = false): bool
    {
        $result = \ArtARTs36\Str\Str::make($this
            ->executeCommand(
                $this
                    ->newCommand()
                    ->addParameter('commit')
                    ->addCutOption('m')
                    ->addParameter($message, true)
                    ->when($amend === true, function (ShellCommandInterface $command) {
                        $command->addOption('amend');
                    })
            ));

        if ($result->contains('nothing to commit')) {
            throw new NothingToCommit();
        }

        return $result->contains('file changed');
    }

    public function fetch(): void
    {
        $this
            ->executeCommand(
                $this
                    ->newCommand()
                    ->addParameter('fetch')
            );
    }

    protected function getConfigReader(): ConfigResultParser
    {
        return $this->config;
    }

    protected function getLogger(): LogParser
    {
        return $this->logger;
    }
}
