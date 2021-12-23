<?php

namespace ArtARTs36\GitHandler\Support;

use ArtARTs36\FileSystem\Contracts\FileSystem;
use ArtARTs36\GitHandler\Exceptions\FileNotFound;

class LocalFileSystem extends \ArtARTs36\FileSystem\Local\LocalFileSystem implements FileSystem
{
    protected function raiseFileNotFoundIfNotExists(string $path): void
    {
        if (! $this->exists($path)) {
            throw new FileNotFound($path);
        }
    }
}
