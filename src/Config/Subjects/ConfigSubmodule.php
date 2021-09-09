<?php

namespace ArtARTs36\GitHandler\Config\Subjects;

use ArtARTs36\GitHandler\Attributes\ConfigKey;
use ArtARTs36\GitHandler\Attributes\ConfigSectionName;

class ConfigSubmodule extends AbstractSubject
{
    #[ConfigSectionName()]
    public $name;

    #[ConfigKey('url')]
    public $url;

    #[ConfigKey('active')]
    public $active;

    public function __construct(string $name, string $url, bool $active)
    {
        $this->name = $name;
        $this->url = $url;
        $this->active = $active;
    }
}
