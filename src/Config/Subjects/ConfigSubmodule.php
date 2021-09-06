<?php

namespace ArtARTs36\GitHandler\Config\Subjects;

use JetBrains\PhpStorm\ArrayShape;

class ConfigSubmodule extends AbstractSubject
{
    public $url;

    public $active;

    public function __construct(string $url, bool $active)
    {
        $this->url = $url;
        $this->active = $active;
    }
}
