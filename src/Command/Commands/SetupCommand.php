<?php

namespace ArtARTs36\GitHandler\Command\Commands;

use ArtARTs36\GitHandler\Command\GitCommandBuilder;
use ArtARTs36\GitHandler\Command\Commands\Contracts\GitSetupCommand;
use ArtARTs36\GitHandler\Contracts\FileSystem;
use ArtARTs36\GitHandler\Exceptions\PathAlreadyExists;
use ArtARTs36\GitHandler\Exceptions\RepositoryAlreadyExists;
use ArtARTs36\GitHandler\Data\GitContext;
use ArtARTs36\ShellCommand\Exceptions\UserExceptionTrigger;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandExecutor;
use ArtARTs36\ShellCommand\Result\CommandResult;
use ArtARTs36\ShellCommand\ShellCommand;

class SetupCommand extends AbstractCommand implements GitSetupCommand
{
    protected $files;

    protected $context;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(
        FileSystem $fileSystem,
        GitContext $context,
        GitCommandBuilder $builder,
        ShellCommandExecutor $executor
    ) {
        $this->files = $fileSystem;
        $this->context = $context;

        parent::__construct($builder, $executor);
    }

    public function init(): bool
    {
        if ($this->isInit()) {
            throw new RepositoryAlreadyExists($this->context->getGitDir());
        } elseif (! $this->files->exists($this->context->getGitDir())) {
            $this->files->createDir($this->context->getRootDir());
        }

        return $this
            ->builder
            ->make()
            ->addArgument('init')
            ->executeOrFail($this->executor)
            ->getResult()
            ->contains('Initialized empty Git repository');
    }

    public function isInit(): bool
    {
        return $this->files->exists($this->context->getGitDir());
    }

    public function clone(string $url, ?string $branch = null, ?string $folder = null): bool
    {
        return $this
            ->builder
            ->make($this->files->belowPath($this->context->getRootDir()))
            ->addArgument('clone')
            ->when($branch !== null, function (ShellCommand $command) use ($branch) {
                $command
                    ->addCutOption('b')
                    ->addArgument($branch);
            })
            ->addArgument($url)
            ->addArgument($folder = $folder ?? $this->files->endFolder($this->context->getRootDir()))
            ->setExceptionTrigger(UserExceptionTrigger::fromCallbacks([
                function (CommandResult $result) use ($folder) {
                    PathAlreadyExists::handleIfSo($folder, $result->getError());
                }
            ]))
            ->executeOrFail($this->executor)
            ->getResult()
            ->contains("Cloning into '{$folder}'");
    }
}
