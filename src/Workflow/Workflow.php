<?php

namespace ArtARTs36\GitHandler\Workflow;

use ArtARTs36\FileSystem\Contracts\FileSystem;
use ArtARTs36\GitHandler\Contracts\Handler\GitHandler;
use ArtARTs36\GitHandler\Contracts\Workflow\GitWorkflow;
use ArtARTs36\GitHandler\Contracts\Workflow\WorkflowElement;

class Workflow implements GitWorkflow
{
    protected $git;

    protected $files;

    protected $elements;

    /**
     * @param list<WorkflowElement> $elements
     */
    public function __construct(GitHandler $git, FileSystem $files, array $elements)
    {
        $this->git = $git;
        $this->files = $files;
        $this->elements = $elements;
    }

    public function dump(string $path): void
    {
        $dumpMap = [];

        foreach ($this->elements as $element) {
            $dumpMap[get_class($element)] = $element->dump($this->git);
        }

        $this->files->createFile($path, serialize($dumpMap));
    }

    public function restore(string $path): void
    {
        $dumpMap = unserialize($this->files->getFileContent($path));

        foreach ($this->elements as $element) {
            $class = get_class($element);

            if (! array_key_exists($class, $dumpMap)) {
                continue;
            }

            $element->restore($this->git, $dumpMap[$class]);
        }
    }
}
