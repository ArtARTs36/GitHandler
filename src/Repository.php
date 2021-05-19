<?php

namespace ArtARTs36\GitHandler;

use ArtARTs36\GitHandler\Contracts\FileSystem;
use ArtARTs36\GitHandler\Contracts\GitHandler;
use ArtARTs36\GitHandler\Files\Attributes;
use ArtARTs36\GitHandler\Files\Ignore;

class Repository
{
    protected $git;

    protected $fileSystem;

    protected $ignore = null;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(GitHandler $git, FileSystem $fileSystem)
    {
        $this->git = $git;
        $this->fileSystem = $fileSystem;
    }

    public function createFolder(string $name): self
    {
        $this->fileSystem->createDir($this->git->getDir()->append(DIRECTORY_SEPARATOR . $name));

        return $this;
    }

    /**
     * @return string - absolute path to file
     */
    public function createFile(string $name, string $content, ?string $folder = null): string
    {
        $path = $this->git->getDir();

        if (! empty($folder)) {
            $path = $path->append(DIRECTORY_SEPARATOR . $folder);

            $this->createFolder($folder);
        }

        $path = $path->append(DIRECTORY_SEPARATOR . $name);

        $this->fileSystem->createFile($path, $content);

        return $path;
    }

    public function delete(): bool
    {
        return $this->fileSystem->removeDir($this->git->getDir());
    }
}
