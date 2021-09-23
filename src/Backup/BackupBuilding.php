<?php

namespace ArtARTs36\GitHandler\Backup;

use ArtARTs36\GitHandler\Contracts\Backup\GitBackupBuilding;
use ArtARTs36\GitHandler\Contracts\Backup\BackupElement;
use ArtARTs36\GitHandler\Backup\Elements\ConfigBackupElement;
use ArtARTs36\GitHandler\Backup\Elements\HookBackupElement;
use ArtARTs36\GitHandler\Backup\Elements\UntrackedFilesBackupElement;

class BackupBuilding implements GitBackupBuilding
{
    protected $elements = [];

    /**
     * @param list<BackupElement> $elements
     */
    public function __construct(array $elements)
    {
        $this->elements = $elements;
    }

    /**
     * @return iterable<BackupElement>
     */
    public function getIterator(): iterable
    {
        return new \ArrayIterator($this->elements);
    }

    public function get(array $classes): array
    {
        $elems = [];

        foreach ($this->elements as $element) {
            if (in_array($element->identity(), $classes) || in_array(get_class($element), $classes)) {
                $elems[] = $element;
            }
        }

        return $elems;
    }

    public function only(array $classes): self
    {
        $elements = $this->get($classes);

        assert(count($elements) > 0, new \LogicException('Not found workflow elements'));

        return new self($elements);
    }
}
