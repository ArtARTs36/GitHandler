<?php

namespace ArtARTs36\GitHandler\Command\Commands;

use ArtARTs36\FileSystem\Contracts\FileSystem;
use ArtARTs36\GitHandler\Command\GitCommandBuilder;
use ArtARTs36\GitHandler\Contracts\Commands\GitIndexCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitSubmoduleCommand;
use ArtARTs36\GitHandler\Data\GitContext;
use ArtARTs36\GitHandler\Files\SubmodulesFile;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandExecutor;

class SubmoduleCommand extends AbstractCommand implements GitSubmoduleCommand
{
    protected $index;

    protected $context;

    protected $file;

    protected $fileSystem;

    public function __construct(
        GitIndexCommand $index,
        GitContext $context,
        FileSystem $fileSystem,
        GitCommandBuilder $builder,
        ShellCommandExecutor $executor
    ) {
        parent::__construct($builder, $executor);

        $this->index = $index;
        $this->context = $context;
        $this->fileSystem = $fileSystem;
        $this->file = new SubmodulesFile();
    }

    public function add(string $url): void
    {
        $this
            ->builder
            ->make()
            ->addArgument('submodule')
            ->addArgument('add')
            ->addOption('force')
            ->addArgument($url)
            ->executeOrFail($this->executor);
    }

    public function getAll(): array
    {
        return $this->file->buildMap($this->fileSystem->getFileContent($this->getPath()));
    }

    public function remove(string $name): void
    {
        $map = $this->getAll();

        $submodule = $map[$name] ?? null;

        if ($submodule === null) {
            throw new \LogicException();
        }

        $this->index->removeCached($dir = $this->context->getRootDir() . DIRECTORY_SEPARATOR . $submodule->path, true);
        $this->fileSystem->removeDir($dir);

        unset($map[$name]);

        $this->saveFromMap($map);
    }

    public function exists(string $name): bool
    {
        return $this->doExists($name, $this->getAll());
    }

    protected function saveFromMap(array $map): bool
    {
        return $this->fileSystem->createFile($this->getPath(), $this->file->buildContent($map));
    }

    protected function doExists(string $name, array $modules): bool
    {
        return array_key_exists($name, $modules);
    }

    public function getPath(): string
    {
        return $this->context->getRootDir() . DIRECTORY_SEPARATOR . '.gitmodules';
    }
}
