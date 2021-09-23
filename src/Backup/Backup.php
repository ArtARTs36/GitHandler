<?php

namespace ArtARTs36\GitHandler\Backup;

use ArtARTs36\GitHandler\Contracts\Backup\GitBackup;
use ArtARTs36\GitHandler\Contracts\Backup\GitBackupBuilding;

class Backup extends AbstractBackup implements GitBackup
{
    public function doRestore(string $path, GitBackupBuilding $building): void
    {
        $dumpMap = unserialize($this->files->getFileContent($path));

        foreach ($building as $element) {
            $class = get_class($element);

            if (! array_key_exists($class, $dumpMap)) {
                continue;
            }

            $element->restore($this->git, $dumpMap[$class]);
        }
    }

    protected function doDump(string $path, BackupBuilding $building): void
    {
        $dumpMap = [];

        foreach ($building as $element) {
            $dumpMap[get_class($element)] = $element->dump($this->git);
        }

        $this->files->createFile($path, serialize($dumpMap));
    }
}
