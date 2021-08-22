<?php

namespace ArtARTs36\GitHandler\DocBuilder;

class Markdown
{
    public static function link(string $title, string $path): string
    {
        return "[$title]($path)";
    }
}
