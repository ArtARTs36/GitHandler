<?php

namespace ArtARTs36\GitHandler\Workflow;

use ArtARTs36\FileSystem\Contracts\FileSystem;
use ArtARTs36\GitHandler\Contracts\Handler\GitHandler;
use ArtARTs36\GitHandler\Contracts\Workflow\GitWorkflow;

class Workflow implements GitWorkflow
{
    protected $git;

    protected $files;

    protected $building;

    public function __construct(GitHandler $git, FileSystem $files, DumpBuilding $building)
    {
        $this->git = $git;
        $this->files = $files;
        $this->building = $building;
    }

    public function building(callable $callback): self
    {
        $callback($this->building);

        return $this;
    }

    public function dump(string $path): void
    {
        $this->doDump($path, $this->building);
    }

    public function dumpOnly(string $path, array $elements): void
    {
        $this->doDump($path, $this->building->only($elements));
    }

    public function restore(string $path): void
    {
        $dumpMap = unserialize($this->files->getFileContent($path));

        foreach ($this->building as $element) {
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
