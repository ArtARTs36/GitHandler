<?php

namespace ArtARTs36\GitHandler\DocBuilder;

use ArtARTs36\GitHandler\Contracts\FileSystem;
use ArtARTs36\Str\Str;

class StubLoader
{
    private $files;

    /** @var array<string, Stub> */
    private $stubs = [];

    public function __construct(FileSystem $files)
    {
        $this->files = $files;
    }

    public function load(string $name): Stub
    {
        if (array_key_exists($name, $this->stubs)) {
            return $this->stubs[$name];
        }

        return $this->stubs[] = $this->doLoad($name);
    }

    private function doLoad(string $name): Stub
    {
        return new Stub($path = $this->buildPath($name), Str::make($this->files->getFileContent($path)));
    }

    private function buildPath(string $name): string
    {
        return __DIR__ . '/stubs/'. $name;
    }
}
