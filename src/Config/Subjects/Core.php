<?php

namespace ArtARTs36\GitHandler\Config\Subjects;

class Core extends AbstractSubject
{
    public $autocrlf;

    public function __construct(string $autocrlf)
    {
        $this->autocrlf = $autocrlf;
    }
}
