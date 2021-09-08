<?php

namespace ArtARTs36\GitHandler\Config\Subjects;

use ArtARTs36\GitHandler\Attributes\GitConfigKey;

class ConfigCommit extends AbstractSubject
{
    #[GitConfigKey('template')]
    public $templatePath;

    public function __construct(string $templatePath)
    {
        $this->templatePath = $templatePath;
    }
}
