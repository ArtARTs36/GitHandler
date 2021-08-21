<?php

namespace ArtARTs36\GitHandler\Attributes;

use ArtARTs36\Str\Facade\Str;
use ArtARTs36\Str\Tab;

class AttributesFile
{
    /**
     * @return array<string, array<\ArtARTs36\Str\Str>>
     */
    public function buildMap(string $content): array
    {
        if (empty(trim($content))) {
            return [];
        }

        $map = [];

        foreach (Str::lines($content) as $match) {
            $parts = $match->deleteUnnecessarySpaces()->words();

            $map[$parts[0]->__toString()] = array_slice($parts, 1);
        }

        return $map;
    }

    /**
     * @param array<string, array<string>> $map
     */
    public function buildContent(array $map): string
    {
        $patterns = array_keys($map);
        $tabs = Tab::addSpaces($patterns);
        $content = '';

        foreach ($patterns as $index => $pattern) {
            $content .= $tabs[$index] . implode(' ', $map[$pattern]);
            $content .= "\n";
        }

        return $content;
    }
}
