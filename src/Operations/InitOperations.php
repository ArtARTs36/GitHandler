<?php

namespace ArtARTs36\GitHandler\Operations;

use ArtARTs36\GitHandler\Contracts\FileSystem;
use ArtARTs36\GitHandler\Exceptions\RepositoryAlreadyExists;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\ShellCommand\ShellCommand;
use ArtARTs36\Str\Str;

trait InitOperations
{
    abstract public function pathToGitFolder(): string;

    abstract protected function getFileSystem(): FileSystem;

    abstract protected function newCommand(?string $dir = null): ShellCommandInterface;

    abstract protected function executeCommand(ShellCommand $command): ?Str;

    abstract public function getDir(): string;

    /**
     * @inheritDoc
     */
    public function init(): bool
    {
        if ($this->isInit()) {
            throw new RepositoryAlreadyExists($this->getDir());
        } elseif (! $this->getFileSystem()->exists($this->getDir())) {
            $this->getFileSystem()->createDir($this->getDir());
        }

        return $this
            ->executeCommand($this->newCommand()->addArgument('init'))
            ->contains('Initialized empty Git repository');
    }

    public function isInit(): bool
    {
        return $this->getFileSystem()->exists($this->pathToGitFolder());
    }
}
