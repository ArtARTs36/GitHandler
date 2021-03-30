<?php

namespace ArtARTs36\GitHandler;

use ArtARTs36\GitHandler\Contracts\ConfigResultParser;
use ArtARTs36\GitHandler\Contracts\FileSystem;
use ArtARTs36\GitHandler\Contracts\GitHandler;
use ArtARTs36\GitHandler\Contracts\LogParser;
use ArtARTs36\GitHandler\Exceptions\BranchNotFound;
use ArtARTs36\GitHandler\Exceptions\FileNotFound;
use ArtARTs36\GitHandler\Exceptions\NothingToCommit;
use ArtARTs36\GitHandler\Exceptions\PathAlreadyExists;
use ArtARTs36\GitHandler\Operations\ConfigOperations;
use ArtARTs36\GitHandler\Operations\InitOperations;
use ArtARTs36\GitHandler\Operations\LogOperations;
use ArtARTs36\GitHandler\Operations\PathOperations;
use ArtARTs36\GitHandler\Operations\PushOperations;
use ArtARTs36\GitHandler\Operations\RemoteOperations;
use ArtARTs36\GitHandler\Operations\TagOperations;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\ShellCommand\ShellCommand;

class Git extends AbstractGitHandler implements GitHandler
{
    use ConfigOperations;
    use InitOperations;
    use TagOperations;
    use LogOperations;
    use RemoteOperations;
    use PushOperations;
    use PathOperations;

    protected $logger;

    private $config;

    private $fileSystem;

    public function __construct(
        string $dir,
        LogParser $logger,
        ConfigResultParser $config,
        FileSystem $fileSystem,
        string $executor = 'git'
    ) {
        parent::__construct($dir, $executor);

        $this->logger = $logger;
        $this->config = $config;
        $this->fileSystem = $fileSystem;
    }

    /**
     * @inheritDoc
     */
    public function pull(?string $branch = null): bool
    {
        return $this
                ->executeCommand(
                    $this
                        ->newCommand()
                        ->addParameter('pull')
                        ->when($branch !== null, function (ShellCommand $command) use ($branch) {
                            $command->addParameter($branch);
                        })
                )
                        ->containsAny([
                            'Already up to date',
                            'Receiving objects',
                            'Resolving deltas',
                        ]);
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
        $sh = $this
            ->executeCommand($this->newCommand()
            ->addParameter('add')
            ->addParameter($file));

        if ($sh === null || $sh->isEmpty()) {
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
        $command = $this->newCommand($this->getFileSystem()->belowPath($this->getDir()))
            ->addParameter('clone')
            ->when($branch !== null, function (ShellCommand $command) use ($branch) {
                $command
                    ->addCutOption('b')
                    ->addParameter($branch);
            })
            ->addParameter($url)
            ->addParameter($folder = $this->fileSystem->endFolder($this->getDir()));

        //

        $sh = $this->executeCommand($command);

        //

        if ($sh->contains("Cloning into '{$folder}'")) {
            return true;
        }

        //

        PathAlreadyExists::handleIfSo($folder, $sh);

        return false;
    }

    /**
     * @inheritDoc
     */
    public function stash(?string $message = null): bool
    {
        return
            $this
                ->executeCommand($this->newCommand()
                    ->addParameter('stash')
                    ->when($message !== null, function (ShellCommand $command) use ($message) {
                        $command
                            ->addParameter('save')
                            ->addParameter('"'. $message .'"');
                    }))
                ->containsAny([
                    'Saved working directory and index',
                    'No local changes to save',
                ]);
    }

    public function commit(string $message, bool $amend = false): bool
    {
        $result = $this
            ->executeCommand(
                $this
                    ->newCommand()
                    ->addParameter('commit')
                    ->addCutOption('m')
                    ->addParameter($message, true)
                    ->when($amend === true, function (ShellCommandInterface $command) {
                        $command->addOption('amend');
                    })
            );

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

    public function version(): string
    {
        return $this->executeCommand($this->newCommand()->addOption('version'))->trim();
    }

    public function help(): string
    {
        return $this->executeCommand($this->newCommand()->addOption('help'))->trim();
    }

    public function pathToGitFolder(): string
    {
        return $this->getDir() . DIRECTORY_SEPARATOR . '.git';
    }

    protected function getConfigReader(): ConfigResultParser
    {
        return $this->config;
    }

    protected function getLogger(): LogParser
    {
        return $this->logger;
    }

    protected function getFileSystem(): FileSystem
    {
        return $this->fileSystem;
    }
}
