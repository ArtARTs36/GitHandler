<?php

namespace ArtARTs36\GitHandler\Backup\Elements;

use ArtARTs36\GitHandler\Contracts\Handler\GitHandler;
use ArtARTs36\GitHandler\Contracts\Workflow\WorkflowElement;

class UntrackedFilesWorkflowElement extends AbstractWorkflowElement implements WorkflowElement
{
    public const IDENTITY = 'files.untracked';

    public function dump(GitHandler $git): array
    {
        $map = [];
        $manager = $git->files();

        foreach ($git->statuses()->getUntrackedFiles() as $file) {
            $map[$file] = $manager->getContent($file);
        }

        return $map;
    }

    /**
     * @param array<string, string> $data
     */
    public function restore(GitHandler $git, array $data): void
    {
        $manager = $git->files();

        foreach ($data as $path => $content) {
            $manager->createFile($path, $content);
        }
    }
}
