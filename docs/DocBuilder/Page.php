<?php

namespace ArtARTs36\GitHandler\DocBuilder;

class Page
{
    public $name;

    public $content;

    public function __construct(string $name, string $content)
    {
        $this->name = $name;
        $this->content = $content;
    }
}
