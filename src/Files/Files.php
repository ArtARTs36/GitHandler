<?php

namespace ArtARTs36\GitHandler\Files;

use ArtARTs36\GitHandler\Contracts\FileSystem;
use ArtARTs36\GitHandler\Contracts\GitFileManager;
use ArtARTs36\GitHandler\Contracts\GitFiles;
use ArtARTs36\GitHandler\Contracts\GitHandler;

class Files implements GitFiles
{
    protected $ignore;

    protected $attributes;

    protected $manager;

    public function __construct(GitHandler $git, FileSystem $fileSystem)
    {
        $this->ignore = new Ignore($git, $fileSystem);
        $this->attributes = new Attributes($git, $fileSystem);
        $this->manager = new FileManager($git, $fileSystem);
    }

    public function ignore(): Ignore
    {
        return $this->ignore;
    }

    public function attributes(): Attributes
    {
        return $this->attributes;
    }

    public function manager(): GitFileManager
    {
        return $this->manager;
    }
}
