<?php

namespace ArtARTs36\GitHandler\Backup;

use ArtARTs36\GitHandler\Contracts\Backup\GitBackup;
use ArtARTs36\GitHandler\Contracts\Backup\GitBackupBuilding;

final class Backup extends AbstractBackup implements GitBackup
{
    public function doRestore(string $path, GitBackupBuilding $building): void
    {
        $dumpMap = unserialize($this->files->getFileContent($path));

        foreach ($building->get(array_keys($dumpMap)) as $element) {
            $element->restore($this->git, $dumpMap[get_class($element)]);
        }
    }

    protected function doDump(string $path, GitBackupBuilding $building): void
    {
        $dumpMap = [];

        foreach ($building as $element) {
            $dumpMap[get_class($element)] = $element->dump($this->git);
        }

        $this->files->createFile($path, serialize($dumpMap));
    }
}
