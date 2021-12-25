<?php

namespace ArtARTs36\GitHandler\DocBuilder;

class Markdown
{
    public static function link(string $title, string $path): string
    {
        return "[$title]($path)";
    }

    public static function tag(string $text): string
    {
        return "`$text`";
    }

    public static function tableLine(array $items): string
    {
        return '|  ' . implode('  |  ', $items) . '  |  ';
    }
}
