<?php

namespace ArtARTs36\GitHandler\Config\Subjects;

use ArtARTs36\GitHandler\Attributes\ConfigKey;
use ArtARTs36\GitHandler\Attributes\ConfigSectionName;

class Alias extends AbstractSubject
{
    #[ConfigSectionName]
    public $name;

    #[ConfigKey()]
    public $script;

    public function __construct(string $name, string $script)
    {
        $this->name = $name;
        $this->script = $script;
    }
}
