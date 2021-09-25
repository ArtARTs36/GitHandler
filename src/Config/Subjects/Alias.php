<?php

namespace ArtARTs36\GitHandler\Config\Subjects;

class Alias extends AbstractSubject
{
    public $name;

    public $script;

    public function __construct(string $name, string $script)
    {
        $this->name = $name;
        $this->script = $script;
    }
}
