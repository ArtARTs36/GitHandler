<?php

namespace ArtARTs36\GitHandler\Command\Groups;

use ArtARTs36\GitHandler\Command\GitCommandBuilder;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitCloneCommand;
use ArtARTs36\GitHandler\Contracts\FileSystem;
use ArtARTs36\GitHandler\Exceptions\PathAlreadyExists;
use ArtARTs36\GitHandler\Exceptions\UnexpectedException;
use ArtARTs36\GitHandler\Data\GitContext;
use ArtARTs36\ShellCommand\Exceptions\UserExceptionTrigger;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandExecutor;
use ArtARTs36\ShellCommand\Result\CommandResult;
use ArtARTs36\ShellCommand\ShellCommand;

class CloneCommand extends AbstractCommand implements GitCloneCommand
{
    protected $files;

    protected $context;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(
        FileSystem $files,
        GitContext $context,
        GitCommandBuilder $builder,
        ShellCommandExecutor $executor
    ) {
        $this->files = $files;
        $this->context = $context;

        parent::__construct($builder, $executor);
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
