<?php

namespace ArtARTs36\GitHandler\Backup;

use ArtARTs36\GitHandler\Contracts\Backup\GitBackup;
use ArtARTs36\GitHandler\Contracts\Backup\BackupElementDict;

final class Backup extends AbstractBackup implements GitBackup
{
    public function doRestore(string $path, BackupElementDict $dict): void
    {
        $dumpMap = unserialize($this->files->getFileContent($path));

        foreach ($dict->get(array_keys($dumpMap)) as $element) {
            $element->restore($this->git, $dumpMap[get_class($element)]);
        }
    }

    protected function doDump(string $path, BackupElementDict $dict): void
    {
        $dumpMap = [];

        foreach ($dict as $element) {
            $dumpMap[get_class($element)] = $element->dump($this->git);
        }

        $this->files->createFile($path, serialize($dumpMap));
    }
}
