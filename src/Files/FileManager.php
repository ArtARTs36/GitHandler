<?php

namespace ArtARTs36\GitHandler\Files;

use ArtARTs36\GitHandler\Contracts\FileSystem;
use ArtARTs36\GitHandler\Contracts\GitFileManager;
use ArtARTs36\GitHandler\Contracts\GitHandler;

class FileManager implements GitFileManager
{
    protected $git;

    protected $files;

    public function __construct(GitHandler $git, FileSystem $files)
    {
        $this->git = $git;
        $this->files = $files;
    }

    public function deleteFile(string $path): bool
    {
        return $this->files->removeFile($this->git->getDir()->append(DIRECTORY_SEPARATOR . $path));
    }
}
