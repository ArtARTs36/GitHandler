<?php

namespace ArtARTs36\GitHandler\Command\Commands;

use ArtARTs36\FileSystem\Contracts\FileSystem;
use ArtARTs36\GitHandler\Command\GitCommandBuilder;
use ArtARTs36\GitHandler\Contracts\Commands\GitSubmoduleCommand;
use ArtARTs36\GitHandler\Data\GitContext;
use ArtARTs36\GitHandler\Data\Submodule;
use ArtARTs36\GitHandler\Files\SubmodulesFile;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandExecutor;

class SubmoduleCommand extends AbstractCommand implements GitSubmoduleCommand
{
    protected $context;

    protected $file;

    protected $fileSystem;

    public function __construct(
        GitContext $context,
        FileSystem $fileSystem,
        GitCommandBuilder $builder,
        ShellCommandExecutor $executor
    ) {
        parent::__construct($builder, $executor);

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
            ->addArgument($url)
            ->executeOrFail($this->executor);
    }

    public function getAll(): array
    {
        return $this->mapArrayToSubmodules($this->file->buildMap(
            $this->fileSystem->getFileContent($this->getPath())
        ));
    }

    public function getPath(): string
    {
        return $this->context->getRootDir() . DIRECTORY_SEPARATOR . '.gitmodules';
    }

    /**
     * @return array<string, Submodule>
     */
    protected function mapArrayToSubmodules(array $array): array
    {
        $modules = [];

        foreach ($array as $item) {
            $modules[$item['name']] = Submodule::fromArray($item);
        }

        return $modules;
    }
}
