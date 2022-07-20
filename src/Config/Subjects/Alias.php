<?php

namespace ArtARTs36\GitHandler\Config\Subjects;

use ArtARTs36\GitHandler\Attributes\ConfigSectionName;
use ArtARTs36\GitHandler\Attributes\ConfigValue;

class Alias extends AbstractSubject
{
    #[ConfigSectionName]
    public $name;

    #[ConfigValue]
    public $script;

    public function __construct(string $name, string $script)
    {
        $this->name = $name;
        $this->script = $script;
    }
}
