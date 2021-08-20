<?php

namespace ArtARTs36\GitHandler\Command\Commands;

use ArtARTs36\GitHandler\Command\GitCommandBuilder;
use ArtARTs36\GitHandler\Contracts\Commands\GitArchiveCommand;
use ArtARTs36\FileSystem\Contracts\FileSystem;
use ArtARTs36\GitHandler\Data\GitContext;
use ArtARTs36\GitHandler\Enum\ArchiveFormat;
use ArtARTs36\GitHandler\Exceptions\PathIsDirectoryNotCould;
use ArtARTs36\ShellCommand\Exceptions\UserExceptionTrigger;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandExecutor;
use ArtARTs36\ShellCommand\Result\CommandResult;

class ArchiveCommand extends AbstractCommand implements GitArchiveCommand
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

    public function create(string $path): void
    {
        $this
            ->builder
            ->make()
            ->addArgument('archive')
            ->addOptionWithValue('format', ArchiveFormat::from(pathinfo($path, PATHINFO_EXTENSION))->value)
            ->addOptionWithValue('output', $path)
            ->addArgument('HEAD')
            ->setExceptionTrigger(UserExceptionTrigger::fromCallbacks([
                function (CommandResult $result) use ($path) {
                    if ($result
                        ->getError()
                        ->contains("fatal: could not create archive file '$path': Is a directory")) {
                        throw new PathIsDirectoryNotCould();
                    }
                }
            ]))
            ->executeOrFail($this->executor);
    }

    public function packRefs(string $path): void
    {
        $this
            ->builder
            ->toDir($this->files->downPath($this->context->getRefsDir()), 'tar')
            ->addCutOption('cf')
            ->addArgument($path)
            ->addArgument(pathinfo($this->context->getRefsDir(), PATHINFO_BASENAME))
            ->executeOrFail($this->executor);
    }

    public function unpackRefs(string $path): void
    {
        $this
            ->builder
            ->toDir($this->context->getGitDir(), 'tar')
            ->addCutOption('xf')
            ->addArgument($path)
            ->executeOrFail($this->executor);
    }
}
