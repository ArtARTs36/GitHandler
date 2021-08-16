<?php

namespace ArtARTs36\GitHandler\Command\Groups;

use ArtARTs36\GitHandler\Command\GitCommandBuilder;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitInitCommand;
use ArtARTs36\GitHandler\Contracts\FileSystem;
use ArtARTs36\GitHandler\Exceptions\RepositoryAlreadyExists;
use ArtARTs36\GitHandler\GitContext;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandExecutor;

class InitCommand extends AbstractCommand implements GitInitCommand
{
    protected $fileSystem;

    protected $context;

    public function __construct(
        FileSystem $fileSystem,
        GitContext $context,
        GitCommandBuilder $builder,
        ShellCommandExecutor $executor
    ) {
        $this->fileSystem = $fileSystem;
        $this->context = $context;

        parent::__construct($builder, $executor);
    }

    public function init(): bool
    {
        if ($this->isInit()) {
            throw new RepositoryAlreadyExists($this->context->getGitDir());
        } elseif (! $this->fileSystem->exists($this->context->getGitDir())) {
            $this->fileSystem->createDir($this->context->getRootDir());
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
        return $this->fileSystem->exists($this->context->getGitDir());
    }
}
