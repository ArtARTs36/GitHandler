<?php

namespace ArtARTs36\GitHandler\Workflow;

use ArtARTs36\GitHandler\Contracts\Workflow\GitBackup;

class Backup extends AbstractBackup implements GitBackup
{
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

    protected function doDump(string $path, WorkflowBuilding $building): void
    {
        $dumpMap = [];

        foreach ($building as $element) {
            $dumpMap[get_class($element)] = $element->dump($this->git);
        }

        $this->files->createFile($path, serialize($dumpMap));
    }
}
