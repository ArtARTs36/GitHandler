<?php

namespace ArtARTs36\GitHandler\DocBuilder;

use ArtARTs36\Str\Str;

class Stub
{
    private $path;

    private $content;

    public function __construct(string $path, Str $content)
    {
        $this->path = $path;
        $this->content = $content;
    }

    public function getContent(): Str
    {
        return $this->content;
    }

    public function render(array $tags = []): Str
    {
        $pTags = [];

        foreach ($tags as $key => $tag) {
            $pTags['{$'. $key . '}'] = $tag;
        }

        return $this->content->replace($pTags);
    }
}
