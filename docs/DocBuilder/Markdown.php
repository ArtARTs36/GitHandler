<?php

namespace ArtARTs36\GitHandler\DocBuilder;

class Markdown
{
    public static function link(string $title, string $path): string
    {
        return "[$title]($path)";
    }

    public static function line(array $rows): string
    {
        return '|  ' . implode('  |  ', $rows) . '  |  ';
    }

    public static function tableHeader(array $rows): string
    {
        return '|  ' . implode('  |  ', $rows) . '  |  ' . "\n" .
               '|  ' . implode('  |  ', array_fill(0, count($rows), '------------')) . '  |  ';
    }
}
