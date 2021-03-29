<?php

namespace ArtARTs36\GitHandler\Operations;

use ArtARTs36\GitHandler\Exceptions\RepositoryAlreadyExists;
use ArtARTs36\GitHandler\Support\FileSystem;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\ShellCommand\ShellCommand;
use ArtARTs36\Str\Facade\Str;

trait InitOperations
{
    abstract protected function newCommand(?string $dir = null): ShellCommandInterface;

    abstract protected function executeCommand(ShellCommand $command): ?string;

    abstract public function getDir(): string;

    /**
     * @inheritDoc
     */
    public function init(): bool
    {
        if ($this->isInit()) {
            throw new RepositoryAlreadyExists($this->getDir());
        } elseif (! file_exists($this->getDir())) {
            FileSystem::createDir($this->getDir());
        }

        return Str::contains($this
            ->executeCommand($this->newCommand()
                ->addParameter('init')), 'Initialized empty Git repository');
    }

    public function isInit(): bool
    {
        return file_exists($this->getDir() . DIRECTORY_SEPARATOR . '.git');
    }
}
