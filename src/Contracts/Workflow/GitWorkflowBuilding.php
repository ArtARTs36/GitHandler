<?php

namespace ArtARTs36\GitHandler\Contracts\Workflow;

interface GitWorkflowBuilding extends \IteratorAggregate
{
    /**
     * @param array<class-string<BackupElement>|string> $classes
     * @return array<BackupElement>
     */
    public function get(array $classes): array;

    /**
     * @param array<class-string<BackupElement>> $classes
     * @return static
     */
    public function only(array $classes);

    /**
     * @return iterable<BackupElement>
     */
    public function getIterator();
}
