<?php

namespace ArtARTs36\GitHandler\Config\Subjects;

class ConfigSubmodule extends AbstractSubject
{
    public $name;

    public $url;

    public $active;

    public function __construct(string $name, string $url, bool $active)
    {
        $this->name = $name;
        $this->url = $url;
        $this->active = $active;
    }
}
