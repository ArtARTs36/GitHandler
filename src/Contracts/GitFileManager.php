<?php

namespace ArtARTs36\GitHandler\Contracts;

interface GitFileManager
{
    public function deleteFile(string $path): bool;
}
