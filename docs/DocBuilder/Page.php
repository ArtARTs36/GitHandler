<?php

namespace ArtARTs36\GitHandler\DocBuilder;

class Page
{
    public $file;

    public $content;

    public $title;

    public function __construct(string $file, string $content, string $title)
    {
        $this->file = $file;
        $this->content = $content;
        $this->title = $title;
    }
}
