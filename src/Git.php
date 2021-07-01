<?php

namespace ArtARTs36\GitHandler;

use ArtARTs36\GitHandler\Contracts\ConfigResultParser;
use ArtARTs36\GitHandler\Contracts\FileSystem;
use ArtARTs36\GitHandler\Contracts\GitHandler;
use ArtARTs36\GitHandler\Contracts\LogParser;
use ArtARTs36\GitHandler\Exceptions\FileNotFound;
use ArtARTs36\GitHandler\Exceptions\NothingToCommit;
use ArtARTs36\GitHandler\Exceptions\PathAlreadyExists;
use ArtARTs36\GitHandler\Exceptions\UnexpectedException;
use ArtARTs36\GitHandler\Operations\BranchOperations;
use ArtARTs36\GitHandler\Operations\ConfigOperations;
use ArtARTs36\GitHandler\Operations\FetchOperations;
use ArtARTs36\GitHandler\Operations\GrepOperations;
use ArtARTs36\GitHandler\Operations\InitOperations;
use ArtARTs36\GitHandler\Operations\LogOperations;
use ArtARTs36\GitHandler\Operations\PathOperations;
use ArtARTs36\GitHandler\Operations\PushOperations;
use ArtARTs36\GitHandler\Operations\RemoteOperations;
use ArtARTs36\GitHandler\Operations\StashOperations;
use ArtARTs36\GitHandler\Operations\StatusOperations;
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
    use StatusOperations;
    use StashOperations;
    use FetchOperations;
    use BranchOperations;
    use GrepOperations;

    protected $logger;

    private $config;

    private $fileSystem;

    /**
     * @codeCoverageIgnore
     */
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
        $command = $this
            ->newCommand()
            ->addParameter('pull')
            ->when($branch !== null, function (ShellCommand $command) use ($branch) {
                $command->addParameter($branch);
            });

        $result = $this->executeCommand($command);

        if ($result->containsAny([
            'Already up to date',
            'Receiving objects',
            'Resolving deltas',
        ])) {
            return true;
        }

        throw new UnexpectedException($command);
    }

    /**
     * @inheritDoc
     */
    public function add(string $file, bool $force = false): bool
    {
        $sh = $this
            ->executeCommand(
                $command = $this
                    ->newCommand()
                    ->addParameter('add')
                    ->addParameter($file)
                    ->when($force, function (ShellCommandInterface $command) {
                        $command->addOption('force');
                    })
            );

        if ($sh === null || $sh->isEmpty()) {
            return true;
        }

        FileNotFound::handleIfSo($file, $sh);

        throw new UnexpectedException($command);
    }

    /**
     * @inheritDoc
     */
    public function clone(string $url, ?string $branch = null, ?string $folder = null): bool
    {
        $command = $this->newCommand($this->getFileSystem()->belowPath($this->getDir()))
            ->addParameter('clone')
            ->when($branch !== null, function (ShellCommand $command) use ($branch) {
                $command
                    ->addCutOption('b')
                    ->addParameter($branch);
            })
            ->addParameter($url)
            ->addParameter($folder = $folder ?? $this->fileSystem->endFolder($this->getDir()));

        //

        $sh = $this->executeCommand($command);

        //

        if ($sh && $sh->contains("Cloning into '{$folder}'")) {
            return true;
        } elseif ($sh !== null) {
            PathAlreadyExists::handleIfSo($folder, $sh);
        }

        throw new UnexpectedException($command);
    }

    public function commit(string $message, bool $amend = false): bool
    {
        $result = $this
            ->executeCommand(
                $command = $this
                    ->newCommand()
                    ->addParameter('commit')
                    ->addCutOption('m')
                    ->addParameter($message, true)
                    ->when($amend === true, function (ShellCommandInterface $command) {
                        $command->addOption('amend');
                    })
            );

        if ($result === null || $result->isEmpty()) {
            throw new UnexpectedException($command);
        }

        if ($result->contains('nothing to commit')) {
            throw new NothingToCommit();
        }

        return $result->contains('file changed');
    }

    public function version(): string
    {
        return $this->executeCommand($this->newCommand()->addOption('version'))->trim();
    }

    public function help(): string
    {
        $result = $this->executeCommand($cmd = $this->newCommand()->addOption('help'));

        if ($result === null || $result->isEmpty()) {
            throw new UnexpectedException($cmd);
        }

        return $result->trim();
    }

    /**
     * @codeCoverageIgnore
     */
    public function pathToGitFolder(): string
    {
        return $this->getDir() . DIRECTORY_SEPARATOR . '.git';
    }

    /**
     * @codeCoverageIgnore
     */
    protected function getConfigReader(): ConfigResultParser
    {
        return $this->config;
    }

    /**
     * @codeCoverageIgnore
     */
    protected function getLogger(): LogParser
    {
        return $this->logger;
    }

    /**
     * @codeCoverageIgnore
     */
    protected function getFileSystem(): FileSystem
    {
        return $this->fileSystem;
    }
}
