<?php

namespace ArtARTs36\GitHandler\Config\Subjects;

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
