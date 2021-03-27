<?php

namespace ArtARTs36\GitHandler;

use ArtARTs36\GitHandler\Contracts\GitHandler;
use ArtARTs36\GitHandler\Support\FileSystem;

class Action
{
    protected $git;

    public function __construct(GitHandler $git)
    {
        $this->git = $git;
    }

    public function createFolder(string $name): self
    {
        $path = $this->git->getDir() . DIRECTORY_SEPARATOR . $name;
        if (!file_exists($path)) {
            mkdir($path);
        }

        return $this;
    }

    /**
     * @return string - absolute path to file
     */
    public function createFile(string $name, string $content, string $folder = null): string
    {
        $path = $this->git->getDir();

        if (! empty($folder)) {
            $path .= DIRECTORY_SEPARATOR . $folder;

            $this->createFolder($folder);
        }

        $path .= DIRECTORY_SEPARATOR . $name;

        file_put_contents($path, $content);

        return $path;
    }

    /**
     * Delete local repository and fetch from origin
     */
    public function reinstall(): void
    {
        $remote = $this->git->showFetchRemote();

        $this->delete();

        $this->git->clone($remote);
    }

    public function delete(): bool
    {
        return FileSystem::removeDir($this->git->getDir());
    }
}
