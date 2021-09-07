<?php

namespace ArtARTs36\GitHandler\Config\Subjects;

class ConfigCommit extends AbstractSubject
{
    public $templatePath;

    public function __construct(string $templatePath)
    {
        $this->templatePath = $templatePath;
    }
}
