<?php

namespace ArtARTs36\GitHandler\Config\Subjects;

class Credential extends AbstractSubject
{
    public $helper;

    public function __construct(string $helper)
    {
        $this->helper = $helper;
    }
}
