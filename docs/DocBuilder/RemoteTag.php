<?php

namespace ArtARTs36\GitHandler\DocBuilder;

use ArtARTs36\Str\Str;

class RemoteTag
{
    public $markdown;

    public $tag;

    public $title;

    public function __construct(Str $markdown, string $tag, string $title)
    {
        $this->markdown = $markdown;
        $this->tag = $tag;
        $this->title = $title;
    }
}
