<?php

namespace ArtARTs36\GitHandler\Command\Groups;

use ArtARTs36\GitHandler\Command\Groups\Contracts\GitFileCommand;
use ArtARTs36\GitHandler\Contracts\FileSystem;
use ArtARTs36\GitHandler\Data\GitContext;

class FileCommand implements GitFileCommand
{
    protected $files;

    protected $context;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(FileSystem $files, GitContext $context)
    {
        $this->files = $files;
        $this->context = $context;
    }

    public function createFile(string $name, string $content, ?string $folder = null): string
    {
        $path = $this->context->getRootDir();

        if (! empty($folder)) {
            $path .= DIRECTORY_SEPARATOR . $folder;

            $this->createFolder($folder);
        }

        $path .= DIRECTORY_SEPARATOR . $name;

        $this->files->createFile($path, $content);

        return $path;
    }

    public function createFolder(string $name): GitFileCommand
    {
        $this->files->createDir($this->context->getRootDir() . DIRECTORY_SEPARATOR . $name);

        return $this;
    }
}