<?php

namespace ArtARTs36\GitHandler;

use ArtARTs36\GitHandler\Contracts\ConfigResultParser;
use ArtARTs36\GitHandler\Contracts\FileSystem;
use ArtARTs36\GitHandler\Contracts\GitHandler;
use ArtARTs36\GitHandler\Contracts\LogParser;
use ArtARTs36\GitHandler\Exceptions\PathAlreadyExists;
use ArtARTs36\GitHandler\Exceptions\UnexpectedException;
use ArtARTs36\ShellCommand\Interfaces\CommandBuilder;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandExecutor;
use ArtARTs36\ShellCommand\ShellCommand;

class Git extends AbstractGitHandler implements GitHandler
{
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
        ShellCommandExecutor $executor,
        CommandBuilder $builder,
        string $bin = 'git'
    ) {
        parent::__construct($dir, $executor, $builder, $bin);

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
            ->addArgument('pull')
            ->when($branch !== null, function (ShellCommand $command) use ($branch) {
                $command->addArgument($branch);
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

    public function version(): string
    {
        return $this->executeCommand($this->newCommand()->addOption('version'))->trim();
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
