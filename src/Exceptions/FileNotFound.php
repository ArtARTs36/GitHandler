<?php

namespace ArtARTs36\GitHandler\Exceptions;

use ArtARTs36\Str\Str;

class FileNotFound extends GitHandlerException implements \ArtARTs36\FileSystem\Contracts\FileNotFound
{
    protected $invalidFilePath;

    public function __construct(string $file)
    {
        $this->invalidFilePath = $file;

        $message = "File '{$file}' Not Found";

        parent::__construct($message);
    }

    public static function handleIfSo(Str $err): void
    {
        if (($path = $err->match("/pathspec '(.*)' did not match any/i")) &&
            $path->isNotEmpty()) {
            throw new self($path);
        }
    }

    public function getInvalidFilePath(): string
    {
        return $this->invalidFilePath;
    }
}
