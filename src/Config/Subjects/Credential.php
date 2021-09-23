<?php

namespace ArtARTs36\GitHandler\Config\Subjects;

use ArtARTs36\GitHandler\Attributes\ConfigKey;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
class Credential extends AbstractSubject
{
    #[ConfigKey('helper')]
    public $helper;

    public function __construct(string $helper)
    {
        $this->helper = $helper;
    }
}
