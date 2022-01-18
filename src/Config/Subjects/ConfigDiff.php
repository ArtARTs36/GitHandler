<?php

namespace ArtARTs36\GitHandler\Config\Subjects;

use ArtARTs36\GitHandler\Attributes\ConfigKey;

class ConfigDiff extends AbstractSubject
{
    #[ConfigKey('external')]
    public $externalPath;

    #[ConfigKey('renames')]
    public $renames;

    public function __construct(string $externalPath, bool $renames)
    {
        $this->externalPath = $externalPath;
        $this->renames = $renames;
    }
}
