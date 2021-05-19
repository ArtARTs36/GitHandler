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

    protected $attributes = null;

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
        $this->fileSystem->createDir($this->git->getDir() . DIRECTORY_SEPARATOR . $name);

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

    /**
     * Delete local repository and fetch from origin
     */
    public function reinstall(?string $branch = null): void
    {
        $remote = $this->git->showRemote()->fetch;

        $this->delete();

        $this->git->clone($remote, $branch);
    }

    public function delete(): bool
    {
        return $this->fileSystem->removeDir($this->git->getDir());
    }

    public function ignore(): Ignore
    {
        if ($this->ignore === null) {
            $this->ignore = new Ignore($this->git, $this->fileSystem);
        }

        return $this->ignore;
    }

    public function attributes(): Attributes
    {
        if ($this->attributes === null) {
            $this->attributes = new Attributes($this->git, $this->fileSystem);
        }

        return $this->attributes;
    }
}
