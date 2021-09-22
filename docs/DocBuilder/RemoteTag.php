<?php

namespace ArtARTs36\GitHandler\DocBuilder;

class RemoteTag
{
    public $markdown;

    public $tag;

    public $title;

    public function __construct(string $markdown, string $tag, string $title)
    {
        $this->markdown = $markdown;
        $this->tag = $tag;
        $this->title = $title;
    }
}
