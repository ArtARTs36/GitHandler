<?php

namespace ArtARTs36\GitHandler\Config\Subjects;

use ArtARTs36\GitHandler\Attributes\ConfigKey;

class ConfigCommit extends AbstractSubject
{
    #[ConfigKey('template')]
    public $templatePath;

    public function __construct(string $templatePath)
    {
        $this->templatePath = $templatePath;
    }
}
