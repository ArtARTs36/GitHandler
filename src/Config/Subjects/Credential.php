<?php

namespace ArtARTs36\GitHandler\Config\Subjects;

use JetBrains\PhpStorm\Immutable;

#[Immutable]
class Credential extends AbstractSubject
{
    public $helper;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(string $helper)
    {
        $this->helper = $helper;
    }
}
