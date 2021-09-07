<?php

namespace ArtARTs36\GitHandler\Workflow;

use ArtARTs36\FileSystem\Contracts\FileSystem;
use ArtARTs36\GitHandler\Contracts\Handler\GitHandler;
use ArtARTs36\GitHandler\Contracts\Workflow\GitWorkflow;

class Workflow implements GitWorkflow
{
    protected $git;

    protected $files;

    protected $default;

    protected $all;

    public function __construct(GitHandler $git, FileSystem $files)
    {
        $this->git = $git;
        $this->files = $files;
        $this->default = (new DumpBuilding())->defaults();
        $this->all = (new DumpBuilding())->all();
    }

    public function dump(string $path): void
    {
        $this->doDump($path, $this->default);
    }

    public function dumpWith(string $path, callable $building): void
    {
        $this->doDump($path, (new DumpBuilding())->bind($building));
    }

    public function restore(string $path): void
    {
        $dumpMap = unserialize($this->files->getFileContent($path));

        foreach ($this->all as $element) {
            $class = get_class($element);

            if (! array_key_exists($class, $dumpMap)) {
                continue;
            }

            $element->restore($this->git, $dumpMap[$class]);
        }
    }

    protected function doDump(string $path, DumpBuilding $building): void
    {
        $dumpMap = [];

        foreach ($building as $element) {
            $dumpMap[get_class($element)] = $element->dump($this->git);
        }

        $this->files->createFile($path, serialize($dumpMap));
    }
}
